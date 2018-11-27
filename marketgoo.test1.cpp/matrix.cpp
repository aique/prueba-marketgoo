/**
 * Prueba de código para MarketGoo. ¡Lee el README.md!
 */
#include <iostream>

#include "termbox/termbox.h"

/**
 * Definimos un método "rgb" para un cálculo rápido del color a usar en un cell
 * con el método de colores de xterm-256color
 */
#define TOCELL(x)  (x * 6 / 256)
uint16_t rgb(int r, int g, int b)
{ return 16 + TOCELL(r) * 36 + TOCELL(g) * 6 + TOCELL(b); }

/**
 * termbox no provee de una función de alto nivel para imprimir cadenas, así
 * que aquí te mostramos como podría ser una función rápida.
 */
void tb_print(int column, int row, const std::string &str, int fg_color)
{
    struct tb_cell cell;
    cell.fg = fg_color;
    cell.bg = 0;

    int x = column;
    for (int i = 0; i < str.size(); ++i) {
        cell.ch = str[i];
        tb_put_cell(x, row, &cell);
        x++;
    }
}

/**
 * Imprimimos una pequeña ayuda para empezar a hacer la prueba: Aquí puedes ver
 * a grosso modo cómo usar las características básicas necesarias.
 */
void ayuda_termbox()
{
    struct tb_cell cell;
    cell.bg = 0;
    cell.fg = rgb(0, 255, 0);

    // Imprimimos como ejemplo algunos carácteres Japoneses Unicode:
    cell.ch = 0x30FB; tb_put_cell(5, 2, &cell);
    cell.ch = 0x30A0; tb_put_cell(5, 3, &cell);
    cell.ch = 0x3031; tb_put_cell(5, 4, &cell);
    cell.ch = 0x308B; tb_put_cell(5, 5, &cell);

    tb_print(10, 2, "Termbox acepta perfectamente", rgb(100, 100, 100));
    tb_print(10, 3, "caracteres Unicode. Mira el", rgb(100, 100, 100));
    tb_print(10, 4, "codigo de ejemplo para los", rgb(100, 100, 100));
    tb_print(10, 5, "caracteres Japoneses.", rgb(100, 100, 100));

    std::string ayuda = "PULSA ESC PARA SALIR";
    tb_print((tb_width() - ayuda.size()) / 2, tb_height() - 2, ayuda, rgb(255, 255, 255));

    // Después de imprimir algo en pantalla hay que "sincronizar" el buffer con
    // el contenido de la consola (termbox usa "double buffers").
    tb_present();
}

int main()
{
    // Antes de utilizar la librería "termbox" hay que inicializarla.
    // Esto nos devuelve un código para saber si nuestro terminal soporta las
    // características adecuadas (¡por si no estamos en un terminal!)
	int code = tb_init();
	if (code < 0) {
		std::cerr << "¡termbox falló! Código: " << code << std::endl;
		return EXIT_FAILURE;
	}

    // Las siguientes funciones inicializan termbox con las siguientes
    // características: Consola de al menos 256 colores y captura de la tecla
    // ESC sin ampliación (ver "termbox/termbox.h" para más info)
    tb_select_output_mode(TB_OUTPUT_256);
	tb_select_input_mode(TB_INPUT_ESC);

    // Imprimimos la pequeña ayuda de termbox
    ayuda_termbox();

    // Entramos en un bucle para detectar la tecla ESC.
    while (true) {
        struct tb_event ev;
        tb_peek_event(&ev, 100);

        if (ev.type == TB_EVENT_KEY) {
            switch (ev.key) {
                case TB_KEY_ESC:
                    // Una vez terminado, hay que hace "shutdown" de termbox. Esto recuperará
                    // el buffer principal de la consola.
                    tb_shutdown();
                    exit(EXIT_SUCCESS);
                    break;
            }
        }
    }

    // Aquí no llega nunca...
    return EXIT_SUCCESS;
}
