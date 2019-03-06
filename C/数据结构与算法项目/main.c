#include "initHead.h"
#include "initFunction.h"

int main()
{
	menu();
	return 0;
}

void menu()
{
	int menu, i;
	do {
		i = 1;
		system("cls");
		puts("1. 任意输入三个数字,使用带指针参数的函数排序 ");
		puts("2. 构造一个链表,并输出该链表 ");
		puts("3. 构造一个链表,搜索指定值,并返回该值所处的位置和地址 ");
		puts("4. 构造一个链表,搜索指定位置,并返回该位置的值和地址 ");
		puts("5. 构造一个链表,并在指定元素后插入新元素 ");
		puts("6. 构造一个链表,并在指定位置后插入新元素 ");
		puts("7. 构造一个链表,并在删除指定位置结点 ");
		puts("8. 构造一个链表,并在删除链表包含的所有指定元素 ");
		puts("9. 构造一个无序链表,并排序输出 ");
		puts("10. 构造两个无序链表,并合并为一个有序链表输出 ");
		puts("11. 将一个链表倒置输出");
		puts("12. 构造一个栈并输出 ");
		puts("13. 构建一个链栈并输出 ");
		puts("14. 使用栈进行十进制到二进制间转换 ");
		puts("15. 构建一个循环队列并输出 ");
		puts("16. 构造一个链队列并输出 ");
		puts("17. 构造一个二叉树并使用先序、中序、后序遍历输出(使用递归算法) ");
		puts("18. 构造一个二叉树并使用先序、中序遍历输出(使用非递归算法) ");
		puts("19. 构造一个二叉树并使用层次遍历输出 ");
		puts("20. 构造一个排序二叉树,允许用户自定义输入元素个数,并使用中序遍历打印输出结果 ");
		puts("21. 计算二叉树的宽度和高度 ");
		puts("22. 计算二叉树的叶子结点和非叶子结点");
		puts("23. 折半查找 ");
		puts("24. 希尔排序 ");
		puts("25. 快速排序 ");
		puts("26. 堆排序");
		puts("27. 构建一个顺序表,插入指定位置元素;在指定元素前插入元素");
		puts("28. 构建一个顺序表,删除指定位置元素;删除指定元素");
		puts("0. 退出本实例 ");
		out("请选择功能:__\b\b");
		in("%d", &menu);
		switch (menu) {
		case 1:
			system("cls");
			pointSwap();
			break;
		case 2:
			system("cls");
			linkedList_creatView();
			break;
		case 3:
			system("cls");
			linkedList_searchElement();
			break;
		case 4:
			system("cls");
			linkedList_searchLoction();
			break;
		case 5:
			system("cls");
			linkedList_insertElement();
			break;
		case 6:
			system("cls");
			linkedList_insertLoction();
			break;
		case 7:
			system("cls");
			linkedList_deleteLoction();
			break;
		case 8:
			system("cls");
			linkedList_deleteElement();
			break;
		case 9:
			system("cls");
			linkedList_sorted();
			break;
		case 10:
			system("cls");
			linkedList_sortedMerge();
			break;
		case 11:
			system("cls");
			linkedList_convert();
			break;
		case 12:
			system("cls");
			stack_creatView();
			break;
		case 13:
			system("cls");
			linkedStack_creatView();
			break;
		case 14:
			system("cls");
			linkedStack_SysConvert();
			break;
		case 15:
			system("cls");
			cirularQueue_creatView();
			break;
		case 16:
			system("cls");
			linkedQueue_creatView();
			break;
		case 17:
			system("cls");
			tree_traversalSys();
			break;
		case 18:
			system("cls");
			tree_traversalUser();
			break;
		case 19:
			system("cls");
			tree_levelTravsersal();
			break;
		case 20:
			system("cls");
			tree_sortedBinaryTree();
			break;
		case 21:
			system("cls");
			tree_getWidthHeight();
			break;
		case 22:
			system("cls");
			tree_countNode();
			break;
		case 23:
			system("cls");
			sortedSeacrh_binarySearch();
			break;
		case 24:
			system("cls");
			sortedSearch_shellSorted();
			break;
		case 25:
			system("cls");
			sortedSearch_quickSorted();
			break;
		case 26:
			system("cls");
			sortedSearch_heapSorted();
			break;
		case 27:
			system("cls");
			sequenceTable_insert();
			break;
		case 28:
			system("cls");
			sequenceTable_delete();
			break;
		}
	} while (menu);
}