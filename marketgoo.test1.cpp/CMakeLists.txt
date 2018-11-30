cmake_minimum_required(VERSION 3.1.0 FATAL_ERROR)
project(MATRIX)

file(GLOB MATRIX_SOURCES "*.cpp")
file(GLOB TERMBOX_SOURCES "termbox/*.c")

add_definitions("-Wall")
set(CMAKE_CXX_FLAGS -pthread)

include_directories(${MATRIX_SOURCE_DIR})
add_executable(matrix ${MATRIX_SOURCES} ${TERMBOX_SOURCES})
