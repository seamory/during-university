#include "Graphic.h"
#include <stdio.h>
#include <conio.h>
#include <iostream>
#include <cstdlib>
using namespace std;

extern "C" void showPic() {
	initgraph(1024, 723, NOCLOSE);
	IMAGE img;
	loadimage(NULL, _T("IMAGE"), _T("MAP"));
	_getch();
	closegraph();
}

extern "C" void drawPath(int loc[256][3], int max, MGraph _G, long int length) {
	char show[50];
	int i;
	initgraph(1024, 723,  SHOWCONSOLE | NOCLOSE);
	IMAGE img;
	loadimage(NULL, _T("IMAGE"), _T("MAP"));
	setlinecolor(0xAA0000);
	setlinestyle(PS_DASH | PS_ENDCAP_ROUND, 3);
	settextcolor(0);
	setbkmode(TRANSPARENT);
	settextstyle(16, 0, _T("宋体"));
	outtextxy(loc[0][0], loc[0][1], _T(_G.vex[loc[0][2]].sight));
	for (i = 1; i < max; i++) {
		line(loc[i -1][0], loc[i -1][1], loc[i][0], loc[i][1]);
		outtextxy(loc[i][0], loc[i][1], _T(_G.vex[loc[i][2]].sight));
		//printf("%d,%d,%d,%d\n", loc[i - 1][0], loc[i - 1][1], loc[i][0], loc[i][1]);
	}
	settextcolor(RED);
	sprintf(show, "路径总长度：%.2lf m", length*1.6);
	if (loc[0][1] - loc[i - 1][1] > 0) {
		outtextxy(loc[0][0], loc[0][1] + 20, _T(show));
		outtextxy(loc[0][0], loc[0][1] + 40, _T("请沿导航虚线行走"));
	} else {
		outtextxy(loc[0][0], loc[0][1] - 20, _T(show));
		outtextxy(loc[0][0], loc[0][1] - 40, _T("请沿导航虚线行走"));
	}
	_getch();
	closegraph();
}