#include "variable.h"
#include "function.h"

void developerInformation()
{
	printf("--------------------------------------\n");
	printf("| 名称： 校园导航系统\n");
	printf("--------------------------------------\n");
}

void AddUser()
{
	int i;
	FILE *fp;
	n++;
	printf("\n输入新插入用户信息\n");
	printf("\n输入新用户名:");
	scanf("%s", stu[n].name);
	fflush(stdin); 
	printf("\n输入新用户密码:");
	scanf("%s", stu[n].secret);
	if ((fp = fopen("user.dat", "w")) == NULL)
	{
		printf("\n保存失败!");
		exit(0);
	}
	else
	{
		for (i = 0; i<N; i++)
			fprintf(fp, "\t%s\t%s\n", stu[i].name, stu[i].secret);
	}
	fclose(fp);
	printf("新用户信息已保存!\n");
	_getch();
	clrscr();
}

void navigationMenu()
{
	int v0, v1, i;
	char ck;
	CreateUDN();
	do {
		ck = Menu();
		switch (ck) {
		case'1':
			clrscr();
			printf("此处填写学校信息"); //此处填写学校信息
			getchar();
			getchar();
			break;
		case '2':
			showPic();
			break;
		case '3':
			clrscr();
			for (i = 1; i<NUM; i++) {
				if (strcmp("road", G.vex[i].sight)) {
					printf("(%d)\t%s\n", i, G.vex[i].sight); 
				}
			}
			printf("请选择起点位置(输入位置编号)：");
			scanf("%d", &v0);
			printf("请选择终点位置(输入位置编号)：");
			scanf("%d", &v1);
			getchar();
			if (v1 != v0) {
				ShortestPath(v0);
				createPath(v0, v1);
			}
			else {
				printf("路径输入无效，您已经在目的地。\n");
				printf("请按回车键继续...");
				getchar();
			}
			break;
		}
	} while (ck != '4');
	clrscr();
}

char Menu() 
{
	char c;
	int flag;
	do {
		clrscr();
		flag = 1;
		Welcome();
		printf("   * 1.学校简介 ┃\n\n");
		printf("   * 2.校园平面简图 ┃\n\n");
		printf("   * 3.校园导航┃\n\n");
		printf("   * 4.退出 ┃\n\n");
		printf("****************************************************\n");
		printf("请输入您的选择：");
		scanf("%c", &c);
		if (c == '1' || c == '2' || c == '3' || c == '4' )
			flag = 0;
	} while (flag);
	return c;
}

void CreateUDN()
{
	FILE *file;
	int i, j = 0;
	int a[200], b[200], c[200], d[200], e[200];
	int m, n;
	G.vexnum = NUM;
	G.arcnum = ARC;
	for (i = 0; i < G.vexnum; i++) {
		G.vex[i].number = i;
		G.vex[i].sight = "road"; 
	}
	if ((file = fopen("sight.dat", "r")) == NULL) {
		printf("找不到文件!\n");
		fclose(file);
		exit(0);
	} else {
		for (j = 0; j < G.vexnum; j++) {
			fscanf(file, "%d%*c%d", &G.vex[j].x, &G.vex[j].y);
			//printf("%d_%d,%d\n", j,  G.vex[j].x, G.vex[j].y);
		}
		fclose(file);
	}

	//地处对于地图上除road结点以外的其他景点部分赋值，参照食堂1、2、3的格式
	G.vex[48].sight = "食堂1";
	G.vex[27].sight = "食堂2";
	G.vex[45].sight = "食堂3";


	if ((file = fopen("location.dat", "r")) == NULL) {
		printf("找不到文件!\n");
		fclose(file);
		exit(0);
	} else {
		for (j = 0; j < G.arcnum; j++) {
			fscanf(file, "%d%*c%d%*c%d%*c%d%*c%d", &a[j], &b[j], &c[j], &d[j], &e[j]);
			//printf("%d_%d,%d,%d,%d,%d\n", j, a[j], b[j], c[j], d[j], e[j]);
		}
		fclose(file);
	}

	for (i = 0; i < G.vexnum; i++) {
		for (j = 0; j < G.vexnum; j++) {
			G.arcs[i][j].adj = Max;
		}
	}

	for (i = 0; i < G.arcnum; i++) {
		for (j = 0; j < G.vexnum; j++) {
			if (a[i] == G.vex[j].x && b[i] == G.vex[j].y) {
				m = j;
				break;
			}
		}
		for (j = 0; j < G.vexnum; j++) {
			if (c[i] == G.vex[j].x && d[i] == G.vex[j].y) {
				n = j;
				break;
			}
		}
		G.arcs[m][n].adj = e[i];
		G.arcs[n][m].adj = e[i];
	}
}

void Welcome() // 屏幕输出函数 
{
	printf("----------------------------------------------------\n");
	printf(" *          * **** *    ****  ****    *   *    ****  \n");
	printf(" *    *    *  *    *    *  *  *  *   **   **   *     \n");
	printf("  *  * *  *   **** *    *     *  *  *  * *  *  ****  \n");
	printf("   **   **    *    *    *  *  *  * *    *    * *     \n");
	printf("    *   *     **** **** ****  **** *         * ****  \n");
	printf("----------------------------------------------------\n");
	printf("****************************************************\n");
}

void ShortestPath(int num)
{
	int v, w, i, t;
	int final[NUM]; 
	int min;
	for (v = 0; v<NUM; v++) {
		final[v] = 0;
		D[v] = G.arcs[num][v].adj;
		for (w = 0; w < NUM; w++) {
			P[v][w] = 0;
		}
		if (D[v]<Max) {
			P[v][num] = 1; 
			P[v][v] = 1; 
		}
	}
	D[num] = 0;
	final[num] = 1; 

	for (i = 0; i<NUM; ++i){
		min = Max;
		for (w = 0; w < NUM; ++w) {
			if (!final[w]) {
				if (D[w] < min) {
					v = w;
					min = D[w];
				}
			}
		}
		final[v] = 1; 
		for (w = 0; w < NUM; ++w) {
			if (!final[w] && ((min + G.arcs[v][w].adj) < D[w])) {
				D[w] = min + G.arcs[v][w].adj;
				for (t = 0; t < NUM; t++) {
					P[w][t] = P[v][t];
				}
				P[w][w] = 1;
			}
		}
	}
}

void createPath(int sight1, int sight2) {
	int a, b, c, d, q = 0;
	int i = 1;
	int loc[256][3];
	a = sight2;
	if (a != sight1) {
		d = sight1;
		loc[0][0] = G.vex[sight1].x;
		loc[0][1] = G.vex[sight1].y;
		loc[0][2] = sight1;
		for (c = 0; c<NUM; ++c) {
			P[a][sight1] = 0;
			for (b = 0; b<NUM; b++) {
				if (G.arcs[d][b].adj < Max && P[a][b]) {
					loc[i][0] = G.vex[b].x;
					loc[i][1] = G.vex[b].y;
					loc[i][2] = b;
					
					i++;
					q = q + 1;
					P[a][b] = 0;
					d = b;
					break;
				}
			}
		}
		drawPath(loc, i, G, D[a]);
	}
}

void cls(HANDLE hConsole) {
	COORD coordScreen = { 0, 0 };
	BOOL bSuccess;
	DWORD cCharsWritten;
	CONSOLE_SCREEN_BUFFER_INFO csbi;
	DWORD dwConSize;
	bSuccess = GetConsoleScreenBufferInfo(hConsole, &csbi);
	PERR(bSuccess, "GetConsoleScreenBufferInfo");
	dwConSize = csbi.dwSize.X * csbi.dwSize.Y;
	bSuccess = FillConsoleOutputCharacter(hConsole, (TCHAR) ' ',
		dwConSize, coordScreen, &cCharsWritten);
	PERR(bSuccess, "FillConsoleOutputCharacter");
	bSuccess = GetConsoleScreenBufferInfo(hConsole, &csbi);
	PERR(bSuccess, "ConsoleScreenBufferInfo");
	bSuccess = FillConsoleOutputAttribute(hConsole, csbi.wAttributes,
		dwConSize, coordScreen, &cCharsWritten);
	PERR(bSuccess, "FillConsoleOutputAttribute");
	bSuccess = SetConsoleCursorPosition(hConsole, coordScreen);
	PERR(bSuccess, "SetConsoleCursorPosition");
	return;
}

void clrscr() {
	cls(GetStdHandle(STD_OUTPUT_HANDLE));
}