#include "initHead.h"

void swapNum(int *x, int *y, int *z, char flag);

void pointSwap(void)
{
	int x[3], i;
	char flag;
	puts("请输入三个数字");
	for (i = 0; i < 3; i++) {
		out("请输入第%d个数:___\b\b\b", i+1);
		in("%d", &x[i]);
	}
	flush;	//清空stdin缓存
	puts("从小到大排列？Y/N");
	in("%c", &flag);
	swapNum(&x[0], &x[1], &x[2], toupper(flag));

	for (i = 0; i < 3; i++) {
		out("%d ", x[i]);
	}
	pause;
}

void swapNum(int *x, int *y, int *z, char flag)
{
	if (flag == 'Y') {
		if (*x > *y) {
			*x += *y;
			*y = *x - *y;
			*x -= *y;
		}
		if (*y > *z) {
			*y += *z;
			*z = *y - *z;
			*y -= *z;
		}
		if (*x > *y) {
			*x += *y;
			*y = *x - *y;
			*x -= *y;
		}
	}
	else {
		if (*x < *y) {
			*x += *y;
			*y = *x - *y;
			*x -= *y;
		}
		if (*y < *z) {
			*y += *z;
			*z = *y - *z;
			*y -= *z;
		}
		if (*x < *y) {
			*x += *y;
			*y = *x - *y;
			*x -= *y;
		}
	}
}