#include "initHead.h"
#include "sortedSearch.h"

void initArray(int **array,int *length)
{
	
	do {
		out("请指定存储空间的大小:__\b\b");
		in("%d", length);
		if ((*length) < 1) {
			puts("存储大小不能小于1");
		}
	} while (*length < 1);
	*array = (int *)malloc(sizeof(int)* (*length));
	flush;
	return array;
}

/*
	type = 0;	允许用户创建一个无序数组
	type = 1;	只允许用户创建一个从小到大排序的数组
	type = 2;	只允许用户创建一个从大到小排序的数组
*/
void creatArray(int *array, int length, int type)
{
	int i = 0;
	switch (type)
	{
	case 0:
		puts("请输入元素值,各个值之间请以空格或回车隔开,超过存储空间长度的数据将被清除.");
		break;
	case 1:
		puts("请从小到大输入元素值,各个值之间请以空格或回车隔开,超过存储空间长度的数据将被清除.");
		break;
	case 2:
		puts("请从大到小输入元素值,各个值之间请以空格或回车隔开,超过存储空间长度的数据将被清除.");
		break;
	default:
		break;
	}

	for (i ; i < length; i++) {
		in("%d", array + i);
	}
	flush;
	if (type == 1) {
		for (i = 0; i < length - 1; i++) {
			if (array[i] - array[i + 1] > 0) {
				puts("未按照从小到大的顺序输入,请重新输入数组元素值.");
				creatArray(array, length, type);
			}
		}
	} else if (type == 2) {
		for (i = 0; i < length - 1; i++) {
			if (array[i] - array[i + 1] < 0) {
				puts("未按照从大到小的顺序输入,请重新输入数组元素值.");
				creatArray(array, length, type);
			}
		}
	}
}

void bubbleSort(int *array, int length)
{
	int i, j, tmp;
	for (i = length-1; i > 0; i--) {
		for (j = 0; j < i; j++) {
			if (array[j] > array[j + 1]) {
				tmp = array[j];
				array[j] = array[j + 1];
				array[j + 1] = tmp;
			}
		}
	}
}

void printArray(int *array, int length)
{
	int i;
	puts("结果为:");
	for (i = 0; i < length; i++) {
		out("%d ", array[i]);
	}
}