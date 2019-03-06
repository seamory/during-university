#include "initHead.h"
#include "sortedSearch.h"

void shellSort(int *array, int length);

void sortedSearch_shellSorted(void)
{
	int *num, length;
	puts("希尔排序");
	initArray(&num, &length);
	creatArray(num, length, 0);
	shellSort(num, length);
	printArray(num, length);

	pause;
}

void shellSort(int *array, int length) 
{
	int i, j, k;
	int gap;
	int temp;
	for (gap = length / 2; gap>0; gap = gap / 2) {
		for (i = 0; i<gap; i++) {
			for (j = i + gap; j<length; j = j + gap) {
				if (array[j] < array[j - gap]) {
					temp = array[j];
					k = j - gap;
					while (k >= 0 && array[k]>temp) {
						array[k + gap] = array[k];
						k = k - gap;
					}
					array[k + gap] = temp;
				}
			}
		}
	}
}
