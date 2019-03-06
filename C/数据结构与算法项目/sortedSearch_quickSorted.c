#include "initHead.h"
#include "sortedSearch.h"

int partitionRowe(int *arr, int low, int high);
void quickSorted(int *arr, int low, int high);
void quickSortedSwap(int *arr, int i, int j);

void sortedSearch_quickSorted(void)
{
	int *num, length;

	initArray(&num, &length);
	creatArray(num, length, 0);
	quickSorted(num, 0, length - 1);
	printArray(num, length);

	pause;
}

int partitionRowe(int *arr, int low, int high)
{
	int pivot = arr[low];
	int low_index = low;
	for (int i = low + 1; i <= high; i++)
	{
		if (arr[i] < pivot)
		{
			low_index++;
			if (i != low_index) 
			{
				quickSortedSwap(arr, i, low_index);
			}
		}
	}
	arr[low] = arr[low_index];
	arr[low_index] = pivot;
	return low_index;
}

void quickSorted(int *arr, int low, int high)
{
	if (high > low)
	{
		int pivot_pos = partitionRowe(arr, low, high);
		quickSorted(arr, low, pivot_pos - 1);
		quickSorted(arr, pivot_pos + 1, high);  
	}
}

void quickSortedSwap(int *arr, int i, int j)
{
	int k = arr[i];
	arr[i] = arr[j];
	arr[j] = k;
}