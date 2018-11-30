#include <iostream>
#include <chrono>
#include <thread>
#include <random>

#include <sys/ioctl.h>
#include <unistd.h>

#include "termbox/termbox.h"

using namespace std::this_thread;
using namespace std::chrono;

/**
 * Definimos un método "rgb" para un cálculo rápido del color a usar en un cell
 * con el método de colores de xterm-256color
 */
#define TOCELL(x)  (x * 6 / 256)
uint16_t rgb(int r, int g, int b)
{ return 16 + TOCELL(r) * 36 + TOCELL(g) * 6 + TOCELL(b); }

class terminal_size
{
    public:

        int get_terminal_rows() {
            return 20;
            return get_terminal_size().ws_row;
        }

        int get_terminal_columns() {
            return 2;
            return get_terminal_size().ws_col;
        }

    private:

    winsize get_terminal_size() {
        struct winsize size;
        ioctl(STDOUT_FILENO,TIOCGWINSZ, &size);

        return size;
    }

};

class matrix_cascade_values
{
    public:

        int get_random_num_visible_chars(int max_length) {
            return get_random_value_in_range(max_length / min_length_proportion, max_length);
        }

        int get_random_delay() {
            return get_random_value_in_range(min_delay, max_delay);
        }

        uint32_t generate_random_char() {
            return get_random_value_in_range(first_unicode_char, last_unicode_char);
        }

        uint16_t get_character_color(unsigned int pos) {
            if (!has_assigned_color(pos)) {
                return rgb(0, 100, 0);
            }

            return char_colors[pos];
        }

    private:

        uint32_t first_unicode_char = 0x30A0;
        uint32_t last_unicode_char = 0x30FF;

        int min_delay = 50;
        int max_delay = 200;

        int min_length_proportion = 4;

        std::vector<uint16_t> char_colors = {
            rgb(255, 255, 255),
            rgb(100, 255, 100),
            rgb(100, 255, 100),
            rgb(0, 255, 0),
            rgb(0, 255, 0),
            rgb(0, 255, 0),
            rgb(0, 175, 0),
            rgb(0, 175, 0),
            rgb(0, 175, 0),
            rgb(0, 175, 0)
        };

        int get_random_value_in_range(int min, int max) {
            std::random_device rd;
            std::mt19937 rng(rd());
            std::uniform_int_distribution<int> uni(min,max);

            return uni(rng);
        }

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

        int x;
        int length;
        int delay;
        int num_visible_chars;
        int visible_chars_head_position;
        std::vector<matrix_cascade_character> characters;

        matrix_cascade(int x, int length) {
            this->x = x;
            this->length = length;
            delay = cascade_values.get_random_delay();
            num_visible_chars = cascade_values.get_random_num_visible_chars(length);
            visible_chars_head_position = 0;
            characters = generate_characters(length);
        }

        void visible_chars_step_forward() {
            visible_chars_head_position++;
            update_characters_color();
        }

        void update_characters_color() {
            for (int i = visible_chars_head_position - num_visible_chars ; i <= visible_chars_head_position ; i++) {
                if (valid_character_position(i)) {
                    characters[i].color = calculate_character_color(i);
                }
            }
        }

        matrix_cascade_character get_char(int pos) {
            return characters[pos];
        }

        uint16_t calculate_character_color(int pos) {
            if (is_invisible_char(pos)) {
                return rgb(0, 0, 0);
            }

            return cascade_values.get_character_color(abs(pos - visible_chars_head_position));
        }

    private:

        matrix_cascade_values cascade_values;

        std::vector<matrix_cascade_character> generate_characters(int length) {
            std::vector<matrix_cascade_character> characters;

            for (int i = 0 ; i < length ; i++) {
                characters.push_back(generate_char(i));
            }

            return characters;
        }

        matrix_cascade_character generate_char(int pos) {
            uint32_t value = cascade_values.generate_random_char();
            uint16_t color = calculate_character_color(pos);
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

bool is_termbox_unavailable() {
    return tb_init() < 0;
}

void show_termbox_error() {
    int error_code = tb_init();
    std::cerr << "¡Termbox falló! Código: " << error_code << std::endl;
}

void tb_settings() {
    tb_select_output_mode(TB_OUTPUT_256);
    tb_select_input_mode(TB_INPUT_ESC);
}

bool check_exit_requested() {
    struct tb_event ev;
    tb_peek_event(&ev, 100);

    if (ev.type == TB_EVENT_KEY && ev.key == TB_KEY_ESC) {
        return true;
    }

    return false;
}

void enable_matrix_in_column(int x, int num_rows) {
    matrix_console console;

    while (true) {
        matrix_cascade cascade = matrix_cascade(x, num_rows);

        while (cascade.visible_chars_head_position < num_rows + cascade.num_visible_chars) {
            console.update(cascade);
            cascade.visible_chars_step_forward();
        }
    }
}

void matrix() {
    terminal_size terminal;
    int num_terminal_columns = terminal.get_terminal_columns();
    int num_terminal_rows = terminal.get_terminal_rows();

    for (int i = 0 ; i < num_terminal_columns ; i++) {
        std::thread matrix_in_column(enable_matrix_in_column, i, num_terminal_rows);
        matrix_in_column.detach();
    }
}

int main()
{
    if (is_termbox_unavailable()) {
        show_termbox_error();
        return EXIT_FAILURE;
    }

    tb_settings();

    matrix();

    bool exit_requested = false;

    while (!exit_requested) {
        tb_present();
        exit_requested = check_exit_requested();
    }

    tb_shutdown();

    return EXIT_SUCCESS;
}
