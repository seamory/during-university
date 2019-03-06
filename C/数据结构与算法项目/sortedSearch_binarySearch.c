#include "initHead.h"
#include "sortedSearch.h"

void binarySearch(int *array, int length);

void sortedSeacrh_binarySearch(void)
{
	int *num, length;

	initArray(&num, &length);
	creatArray(num, length, 1);
	binarySearch(num, length);

	pause;
}

void binarySearch(int *array, int length)
{
	int start, mid, end, x;
	start = 0;
	end = length - 1;
	mid = (start + end) / 2;
	out("请输入查找的值，将输入该值在数组中的位置:__\b\b");
	in("%d", &x);
	while (start != end) {
		if (x < array[mid]) {
			end = mid - 1;
			mid = (start + end) / 2;
		} else if (x > array[mid]) {
			start = mid + 1;
			mid = (start + end) / 2;
		} else {
			break;
		}
	}
	if (array[mid] == x) {
		out("%d在数组中的位置为%d", x, mid + 1);
	} else {
		out("未能在给定数组中找到指定元素.");
	}
}