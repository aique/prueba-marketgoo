#include <iostream>
#include <chrono>
#include <thread>
#include <random>

#include <sys/ioctl.h>
#include <unistd.h>

#include "termbox/termbox.h"

using namespace std::this_thread;
using namespace std::chrono;

#define TOCELL(x)  (x * 6 / 256)
uint16_t rgb(int r, int g, int b)
{ return 16 + TOCELL(r) * 36 + TOCELL(g) * 6 + TOCELL(b); }

class matrix_color
{
    public:

        const uint16_t WHITE = rgb(255, 255, 255);
        const uint16_t WHITE_GREEN = rgb(150, 255, 150);
        const uint16_t LIGHT_GREEN = rgb(0, 255, 0);
        const uint16_t GREEN = rgb(0, 255, 0);
        const uint16_t DARK_GREEN =  rgb(0, 100, 0);
        const uint16_t INVISIBLE = rgb(0, 0, 0);
};

class matrix_cascade_values
{
    public:

        // número de caracteres ya visibles que se actualizarán aleatoriamente
        int get_random_num_updatable_chars() {
            return get_random_value_in_range(0, max_updatable_chars);
        }

        // número de caracteres que componen la cascada
        int get_random_num_visible_chars(int max_length) {
            return get_random_value_in_range(max_length / min_length_proportion, max_length);
        }

        // velocidad de caída
        int get_random_delay() {
            return get_random_value_in_range(min_delay, max_delay);
        }

        uint32_t generate_random_char() {
            return get_random_value_in_range(first_unicode_char, last_unicode_char);
        }

        // color del carácter en función de su posición en la cascada
        uint16_t get_character_color(unsigned int pos) {
            if (!has_assigned_color(pos)) {
                return color.DARK_GREEN;
            }

            return char_colors[pos];
        }

        uint16_t get_invisible_color() {
            return color.INVISIBLE;
        }

        // devuelve un entero aleatorio dentro de un rango
        int get_random_value_in_range(int min, int max) {
            std::random_device rd;
            std::mt19937 rng(rd());
            std::uniform_int_distribution<int> uni(min,max);

            return uni(rng);
        }

    private:

        matrix_color color;

        // número máximo de caracteres actualizados aleatoriamente
        const int max_updatable_chars = 3;

        // rango de caractéres que componen la cascada
        const uint32_t first_unicode_char = 0x30A0;
        const uint32_t last_unicode_char = 0x30FF;

        // rango de valores para la velocidad de caída
        const int min_delay = 50;
        const int max_delay = 150;

        // proporción mínima de la altura de la cascada con respecto a la terminal
        const int min_length_proportion = 4;

        // patrón de colores de la cascada en función de la posición del carácter
        const std::vector<uint16_t> char_colors = {
            color.WHITE,
            color.WHITE_GREEN,
            color.WHITE_GREEN,
            color.LIGHT_GREEN,
            color.LIGHT_GREEN,
            color.LIGHT_GREEN,
            color.GREEN,
            color.GREEN,
            color.GREEN,
            color.GREEN
        };

        bool has_assigned_color(unsigned int pos) {
            return pos < char_colors.size();
        }
};

class matrix_cascade_character
{
    public:

        uint32_t value;
        uint16_t color;

        matrix_cascade_character(uint32_t value, uint16_t color) {
            this->value = value;
            this->color = color;
        }
};

class matrix_cascade
{
    public:

        // posición de la cascada dentro de las columnas de la terminal
        int x;
        // altura de la cascada, será del mismo tamaño que el alto de la terminal
        int length;
        // velocidad de caída
        int delay;
        // número de caracteres visibles dentro de la cascada
        int num_visible_chars;
        // posición de la cabeza de los caracteres visibles de la cascada
        int visible_chars_head_position;
        // conjunto de caractéres que componen la cascada
        std::vector<matrix_cascade_character> characters;

        matrix_cascade(int x, int length) {
            this->x = x;
            this->length = length;
            delay = cascade_values.get_random_delay();
            num_visible_chars = cascade_values.get_random_num_visible_chars(length);
            visible_chars_head_position = 0;
            characters = generate_characters(length);
        }

        // hace avanzar un carácter a la cascada, actualiza aleatoriamente alguno de sus caracteres y adapta los colores
        void visible_chars_step_forward() {
            visible_chars_head_position++;
            update_random_chars();
            update_chars_color();
        }

        void update_chars_color() {
            for (int i = visible_chars_head_position - num_visible_chars ; i <= visible_chars_head_position ; i++) {
                if (valid_character_position(i)) {
                    characters[i].color = calculate_char_color(i);
                }
            }
        }

        matrix_cascade_character get_char(int pos) {
            return characters[pos];
        }

        uint16_t calculate_char_color(int pos) {
            if (is_invisible_char(pos)) {
                return cascade_values.get_invisible_color();
            }

            int position_in_visible_chars = abs(pos - visible_chars_head_position);
            return cascade_values.get_character_color(position_in_visible_chars);
        }

    private:

        matrix_cascade_values cascade_values;

        void update_random_chars() {
            int num_updatable_chars = cascade_values.get_random_num_updatable_chars();

            for (int i = 0 ; i < num_updatable_chars ; i++) {
                int min_pos = get_updatable_chars_min_pos();
                int max_pos = get_updatable_chars_max_pos();
                int updatable_pos = cascade_values.get_random_value_in_range(min_pos, max_pos);

                characters[updatable_pos].value = cascade_values.generate_random_char();
            }
        }

        int get_updatable_chars_min_pos() {
            int min_pos = visible_chars_head_position - num_visible_chars;

            if (min_pos < 0) {
                min_pos = 0;
            }

            if (min_pos > length - 1) {
                min_pos = length - 1;
            }

            return min_pos;
        }

        int get_updatable_chars_max_pos() {
            int max_pos = visible_chars_head_position;

            if (max_pos > length - 1) {
                max_pos = length - 1;
            }

            return max_pos;
        }

        std::vector<matrix_cascade_character> generate_characters(int length) {
            std::vector<matrix_cascade_character> characters;

            for (int i = 0 ; i < length ; i++) {
                characters.push_back(generate_char(i));
            }

            return characters;
        }

        matrix_cascade_character generate_char(int pos) {
            uint32_t value = cascade_values.generate_random_char();
            uint16_t color = calculate_char_color(pos);
            matrix_cascade_character character(value, color);

            return character;
        }

        bool is_invisible_char(int pos) {
            return pos > visible_chars_head_position || pos <= (visible_chars_head_position - num_visible_chars);
        }

        bool valid_character_position(unsigned int pos) {
            return pos >= 0 && pos < characters.size();
        }
};

class matrix_console
{
    public:

        void update(matrix_cascade cascade) {
            print_cascade(cascade);
            sleep_for(milliseconds(cascade.delay));
        }

        void print_cascade(matrix_cascade cascade) {
            for (int i = 0 ; i < cascade.length ; i++) {
                matrix_cascade_character character = cascade.get_char(i);
                tb_change_cell(cascade.x, i, character.value, character.color, 0);
            }
        }
};

class matrix
{
    public:

        int num_columns;
        int num_rows;

        matrix(int num_columns, int num_rows) {

            this->num_columns = num_columns;
            this->num_rows = num_rows;

            for (int i = 0 ; i < num_columns ; i++) {
                int init_delay = cascade_values.get_random_value_in_range(0, max_init_delay);
                std::thread matrix_in_column(column, i * 2, num_rows, init_delay);
                matrix_in_column.detach();
            }
        }

    private:

        matrix_cascade_values cascade_values;

        // máximo valor para el delay inicial de cada cascada
        const int max_init_delay = 5000;

        static void column(int x, int num_rows, int init_delay) {
            matrix_console console;

            // permite que el efecto de la cascada se mantenga desde el comienzo
            sleep_for(milliseconds(init_delay));

            while (true) {
                matrix_cascade cascade = matrix_cascade(x, num_rows);

                while (cascade.visible_chars_head_position < num_rows + cascade.num_visible_chars) {
                    console.update(cascade);
                    cascade.visible_chars_step_forward();
                }
            }
        }
};

class termbox_handler
{
    public:

        bool is_unavailable() {
            return tb_init() < 0;
        }

        void show_error() {
            int error_code = tb_init();
            std::cerr << "¡Termbox falló! Código: " << error_code << std::endl;
        }

        void settings() {
            tb_select_output_mode(TB_OUTPUT_256);
            tb_select_input_mode(TB_INPUT_ESC);
        }

        void print() {
            tb_present();
        }

        void shutdown() {
            tb_shutdown();
        }

        bool check_exit_requested() {
            struct tb_event ev;
            tb_peek_event(&ev, 100);

            if (ev.type == TB_EVENT_KEY && ev.key == TB_KEY_ESC) {
                return true;
            }

            return false;
        }
};

class terminal_size
{
    public:

        int get_terminal_rows() {
            return get_terminal_size().ws_row;
        }

        int get_terminal_columns() {
            return get_terminal_size().ws_col / 2;
        }

    private:

        winsize get_terminal_size() {
            struct winsize size;
            ioctl(STDOUT_FILENO,TIOCGWINSZ, &size);

            return size;
        }
};

int main()
{
    termbox_handler termbox;
    terminal_size terminal;

    if (termbox.is_unavailable()) {
        termbox.show_error();
        return EXIT_FAILURE;
    }

    termbox.settings();

    matrix(terminal.get_terminal_columns(), terminal.get_terminal_rows());

    bool exit_requested = false;

    while (!exit_requested) {
        termbox.print();
        exit_requested = termbox.check_exit_requested();
    }

    termbox.shutdown();

    return EXIT_SUCCESS;
}
