#include "initHead.h"
#include "stack.h"

void linkedStack_SysConvert(void)
{
	NODE *top;
	top = newLSNode();
	int x, tmp;
	puts("十进制到二进制间转换");
	out("请输入数字:__\b\b");
	in("%d", &x);
	if (x) {
		while (x) {
			pushLS(top, x % 2);
			x = x / 2;
		}
	} else {
		pushLS(top, 0);
	}
	out("二进制结果为 : ");
	wipeLinkedStack(top);
	pause;
}
