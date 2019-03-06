#include "initHead.h"
#include "sequenceTable.h"

void initSequenceTable(int **array, int *length)
{
	do {
		out("请指定顺序表存储空间的长度(系统将会为插入操作默认保留10个空间):__\b\b");
		in("%d", length);
		if (*length < 1) {
			puts("存储空间长度不能指定为0");
		}
	}while (*length < 1);

	*array = (int*)malloc(sizeof(int) * ((*length) + 10));
}

void creatSequenceTable(int *array, int length)
{
	int i = 0, x;
	out("请为顺序表赋值,键入0结束赋值(元素个数超过长度将被清除):__\b\b");
	while (i < length) {
		in("%d", &x);
		if (x) {
			array[i] = x;
		} else {
			break;
		}
		i++;
	}
}

void sequenceTableInsertLocation(int *array, int *length, int i, int x)
{
	int j = *length, tmp;
	if (i > 0 && i <= *length) {
		for (; j > i - 1; j--) {
			array[j] = array[j - 1];
		}
		array[j] = x;
		(*length)++;
	} else {
		puts("指定位置不存在");
	}
}

void sequenceTableInsertElement(int *array, int *length, int e, int x)
{
	int loc;
	int j = *length;
	if (loc = sequenceTableSearch(array, length, e)) {
		for (j; j > loc; j--) {
			array[j] = array[j - 1];
		}
		array[loc] = x;
		(*length)++;
	} else {
		puts("指定元素不存在");
	}
}

void sequenceTableDeleteLocation(int *array, int *length, int i)
{
	if (i < *length) {
		i--;
		for (i; i < *length - 1; i++) {
			array[i] = array[i + 1];
		}
		(*length)--;
	} else {
		out("指定位置不存在");
	}
}

void sequenceTableDeleteElement(int *array, int *length, int x)
{
	int i;
	if (i = sequenceTableSearch(array, *length, x)) {
		i--;
		for (i; i < *length - 1; i++) {
			array[i] = array[i + 1];
		}
		(*length)--;
	} else {
		out("指定元素不存在");
	}
}

int sequenceTableSearch(int *array, int length, int x)
{
	int i;
	for (i = 0; i < length; i++) {
		if (array[i] == x) {
			return i + 1;
		}
	}
	return 0;
}

void sequenceTablePrint(int *array, int length)
{
	int i = 0;
	out("当前顺序表为: ");
	for (; i < length; i++) {
		out("%d ", array[i]);
	}
}