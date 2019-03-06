#include "initHead.h"
#include "sortedSearch.h"


void heapSortSwap(int *p1, int *p2);
int parent(int p);
int leftChild(int p);
int rightChild(int p);

void maxHeapify(int *array, const int length, int p);
void buildMaxHeap(int *array, const int length);
void heapSort(int *array, const int length);

void sortedSearch_heapSorted(void)
{
	int *num, length;
	initArray(&num, &length);
	creatArray(num, length, 0);
	heapSort(num, length);
	printArray(num, length);
	pause;
}

void heapSortSwap(int *p1, int *p2) {
	int temp = *p1;
	*p1 = *p2;
	*p2 = temp;
}

int parent(int p) {
	return (p - 1) / 2;
}

int leftChild(int p) {
	return 2 * p + 1;
}

int rightChild(int p) {
	return 2 * p + 2;
}

void maxHeapify(int *array, int length, int p) {
	int max = p;
	if (leftChild(p) < length && array[max] < array[leftChild(p)]) {
		max = leftChild(p);
	}
	if (rightChild(p) < length && array[max] < array[rightChild(p)]) {
		max = rightChild(p);
	}
	if (max == p) return;
	heapSortSwap(&array[max], &array[p]);
	maxHeapify(array, length, max);
}

void buildMaxHeap(int *array, int length) {
	int count = length / 2;
	for (; count >= 0; count--) {
		maxHeapify(array, length, count);
	}
}

void heapSort(int *array, int length) {
	buildMaxHeap(array, length);
	int count = 1;
	for (count = 1; count < length; count++) {
		heapSortSwap(&array[0], &array[length - count]);
		maxHeapify(array, length - count, 0);
	}
}