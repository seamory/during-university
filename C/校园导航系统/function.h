#pragma once
#include "struct.h"

void AddUser();
void CreateUDN();
void Welcome();
void ShortestPath(int num);
void createPath(int sight1, int sight2);
char Menu();
void navigationMenu();
void developerInformation();
void showPic();
void drawPath(int loc[256][3], int max, MGraph _G, long int length);
void cls(HANDLE hConsole);
void clrscr();