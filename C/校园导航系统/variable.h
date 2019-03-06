#define _CRT_SECURE_NO_DEPRECATE

#include <stdio.h>
#include <stdlib.h>
#include <conio.h>
#include <string.h>
#include <windows.h>

#ifndef GLOBLE
#define GLOBLE
#define N 10
#define Max 9999
#define NUM 66
#define ARC 114
#endif // STRUCT

/* Standard error macro for reporting API errors */
#define PERR(bSuccess, api){if(!(bSuccess)) printf("%s:Error %d from %s \
on line %d\n", __FILE__, GetLastError(), api, __LINE__);}