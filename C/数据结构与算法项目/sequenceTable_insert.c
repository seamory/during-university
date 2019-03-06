#include "initHead.h"
#include "sequenceTable.h"

void sequenceTable_insert(void)
{
	int *num, length;
	int loc, x;
	initSequenceTable(&num, &length);
	creatSequenceTable(num, length);
	out("\n请输入插入的位置:__\b\b");
	in("%d", &loc);
	flush;
	out("\n请输入在该的位置插入的值:__\b\b");
	in("%d", &x);
	flush;
	sequenceTableInsertLocation(num, &length, loc, x);
	out("结果为: ");
	sequenceTablePrint(num, length);

	out("\n请指定插入元素的前件元素的值:__\b\b");
	in("%d", &loc);
	flush;
	out("\n请输入插入的值:__\b\b");
	in("%d", &x);
	sequenceTableInsertElement(num, &length, loc, x);
	out("结果为: ");
	sequenceTablePrint(num, length);

	pause;
}