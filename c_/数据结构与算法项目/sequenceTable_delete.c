#include "initHead.h"
#include "sequenceTable.h"

void sequenceTable_delete(void)
{
	int *num, length;
	int loc;
	initSequenceTable(&num, &length);
	creatSequenceTable(num, length);
	out("\n请输入删除的位置:__\b\b");
	in("%d", &loc);
	flush;
	sequenceTableDeleteLocation(num, &length, loc);
	out("结果为: ");
	sequenceTablePrint(num, length);

	out("\n请输入删除的元素:__\b\b");
	in("%d", &loc);
	sequenceTableDeleteElement(num, &length, loc);
	out("结果为: ");
	sequenceTablePrint(num, length);
	pause;
}