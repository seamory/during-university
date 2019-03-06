#pragma once
#ifndef INITHEAD
#define INITHEAD

#include <stdio.h>
#include <stdlib.h>
#include <conio.h>
#include <ctype.h>
#include <string.h>
#include <malloc.h>

char ch;
#define flush while( (ch = getchar() ) != '\n' && ch != EOF)
#define pause flush; puts("\n请按任意键继续..."); getch()
#define out(...) printf(__VA_ARGS__)
#define in(...) while( scanf(__VA_ARGS__) ==0 ){ flush; puts("\n输入有误，请重新输入");}

typedef enum { false, true } bool;

#endif // !INITHEAD
