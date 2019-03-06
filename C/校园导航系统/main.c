#include "variable.h"
#include "function.h"
#include <conio.h>
int main() {
	char s2[128], s3[128], s4[128], s5[128], s6[128], s1[128], s7[128] = "\0";
	int i = 0, a, j;
	FILE *fp;
	if ((fp = fopen("user.dat", "r")) == NULL) {
		printf("找不到用户文件!\n");
		_getch();
		exit(0);
	} else {
		fscanf(fp, "\t%d\n", &n);
		for (i = 0; i<N; i++)
			fscanf(fp, "\t%s\t%s\n", stu[i].name, stu[i].secret);
	}
	fclose(fp);
	printf("用户信息读入程序中!");
	clrscr();
	for (i = 0; i<3; i++) {
		developerInformation();
		printf("用户登陆\n");
		printf("请输入用户名，你还有%d次机会：________\b\b\b\b\b\b\b", 3 - i);
		gets_s(s3,127);
		if ( !strcmp(s3, s7) ) {
			printf("用户名不能空格，谢谢！！！");
			printf("用户名不正确，请从新输入。\n");
			_getch();
			clrscr();
			if (i == 2) {
				printf("用户名不正确，按任意键退出。");
				exit(0);
			}
			continue;
		}
		for (j = 0; j<N; j++) {
			if (!strcmp(stu[j].name, s3)) {
				printf("用户名正确\n");
				strcpy(s1, stu[j].name);
				strcpy(s2, stu[j].secret);
				clrscr();
				break;
			}
		}
		if (!strcmp(s1, s3))
			break;
		printf("用户名不正确，请从新输入。\n");
		_getch();
		if (i == 2) {
			printf("用户名和密码不匹配，按任意键退出。\n");
			_getch();
			exit(0);
		}
		clrscr();
	}
	clrscr();
	for (i = 0; i<3; i++) {
		printf("请输入用户密码，你还有%d次机会：________\b\b\b\b\b\b\b", 3 - i);
		gets_s(s4,127);
		if (!strcmp(s2, s4)) {
			clrscr();
			break;
		} else if (i == 2) {
			clrscr();
			printf("用户名和密码不匹配，按任意键退出。");
			exit(0);
		} else {
			clrscr();
			printf("输入错误，请从新输入:\n");
		}
	}
	clrscr();
	for (i = 0;; i++)
	{
		clrscr();
		developerInformation();
		printf(" ****************************** \n");
		printf(" *    1.退出系统              * \n");
		printf(" *                            * \n");
		printf(" *    2.校园导航系统          * \n");
		printf(" *                            * \n");
		printf(" *    3.新增用户信息          * \n");
		printf(" *                            * \n");
		printf(" *    0.修改密码              * \n");
		printf(" ****************************** \n");
		printf("请选择功能\n");
		scanf("%d", &a);
		if (a == 1) {
			printf("按任意键退出\n");
			break;
		}
		getchar();
		if (a == 2) {
			navigationMenu();
			clrscr();
		}
		if (a == 3) {
			AddUser();
			clrscr();
		}
		if (a == 0) {
			for (i = 0; i<3; i++) {
				clrscr();
				developerInformation();
				printf("\n\n请输入原密码\n");
				printf("两次不正确，系统将自动返回，你还有%d次机会。\n", 3 - i - 1);
				gets_s(s3,127);
				if (!strcmp(s2, s3)) {
					for (i = 0;; i++) {
						printf("\n请输入新密码\n");
						gets_s(s6,127);
						printf("\n请在此输入新密码\n");
						gets_s(s5,127);
						if (!strcmp(s5, s6)) {
							clrscr();
							printf("新密码为: %s\n", s5);
							strcpy(s2, s5);
							strcpy(stu[j].secret, s2);
							if ((fp = fopen("user.dat", "w")) == NULL) {
								printf("\n保存失败!");
								exit(0);
							} else {
								for (i = 0; i<N; i++)
									fprintf(fp, "\t%s\t%s\n", stu[i].name, stu[i].secret);
							}
							fclose(fp);
							printf("新用户信息已保存在用户信息中!\n");
							_getch();
							clrscr();
							break;
						} else
							clrscr();
						printf("\n\n两次输入密码不一样，密码修改失败\n");
						break;
					}
					break;
				} else {
					printf("原密码输入错误\n");
					printf("请珍惜机会，从新输入。");
					_getch();
					clrscr();
				}
				if (i == 2) {
					exit(0);
				}
			}
		}
	}
}