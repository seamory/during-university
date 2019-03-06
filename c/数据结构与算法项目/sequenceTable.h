#pragma once
#ifndef __SEQUENCETABLE_H_
#define __SEQUENCETABLE_H_

#include "initHead.h"

void initSequenceTable(int **array, int *length);
void creatSequenceTable(int *array, int length);
void sequenceTableInsertLocation(int *array, int *length, int i, int x);
void sequenceTableInsertElement(int *array, int *length, int e, int x);
void sequenceTableDeleteLocation(int *array, int *length, int i);
void sequenceTableDeleteElement(int *array, int *length, int x);
int sequenceTableSearch(int *array, int length, int x);
void sequenceTablePrint(int *array, int length);

#endif // !__SEQUENCETABLE_H_
