#include "initHead.h"
#include "tree.h"

stackNode *newStreeNode(void)
{
	stackNode *node;
	node = (stackNode *)malloc(sizeof(stackNode));
	node->next = NULL;
	return node;
}

void pushTreeNode(stackNode *top, treeNode *tNode)
{
	stackNode *Snode;
	Snode = newStreeNode();
	Snode->node = tNode;
	Snode->next = top->next;	//此处不可以省略
	top->next = Snode;
}

bool popTreeNode(stackNode *top, treeNode **tNode)
{
	stackNode *Snode;
	if (top->next) {
		Snode = top->next;
		top->next =Snode->next;
		*tNode = Snode->node;
		free(Snode);
		return true;
	}
	else {
		*tNode = NULL;
		return false;
	}
}

bool emptyTreeStack(stackNode *top)
{
	if (top->next == NULL) {
		return true;
	}else{
		return false;
	}
}

queueNode *newQtreeNode()
{
	queueNode *node;
	node = (queueNode *)malloc(sizeof(queueNode));
	node->next = NULL;
	return node;
}

void inTreeNode(queueNode **rear, treeNode *tNode)
{
	queueNode *Qnode;
	Qnode = newQtreeNode();
	Qnode->node = tNode;
	Qnode->next = (*rear)->next;
	(*rear)->next = Qnode;
	*rear = Qnode;
}

bool outTreeNode(queueNode *front, queueNode **rear, treeNode **tNode)
{
	queueNode *Qnode;
	if (front->next) {
		Qnode = front->next;
		*tNode = Qnode->node;
		front->next = Qnode->next;
		if (Qnode->next == NULL) {
			*rear = front;
		}
		free(Qnode);
		return true;
	}
	else {
		*tNode = NULL;
		return false;
	}
}

bool emptyTreeQueue(queueNode *front)
{
	if (front->next) {
		return false;
	} else {
		return true;
	}
}

int countTreeQueue(queueNode *front)
{
	int i = 0;
	queueNode *p;
	p = front;
	while(p->next) {
		p = p->next;
		i++;
	}
	return i;
}

treeNode *newTreeNode(void)
{
	treeNode * node;
	node = (treeNode *)malloc(sizeof(treeNode));
	node->lchild = NULL;
	node->rchild = NULL;
	return node;
};

treeNode *creatTree(void)
{
	treeNode *root, *array;
	int length = 512;	//使用系统开销来建立树
	int i = 0,x;
	array = (treeNode *)malloc(sizeof(treeNode)*length);
	
	puts("请输入二叉树结点元素,键入0开始建立完全二叉树;");
	out("请输入:__\b\b");
	do {
		in("%d", &x);
		array[i].data = x;
		i++;
	} while (x != 0 && i < 512);

	x = i - 1;
	i = 0;

	while (array[i].data != 0) {
		if (2 * i + 1 < x) {
			array[i].lchild = &array[2 * i + 1];
		} else {
			array[i].lchild = NULL;
		}

		if (2 * i + 2 < x) {
			array[i].rchild = &array[2 * i + 2];
		}
		else {
			array[i].rchild = NULL;
		}
		i++;
	}
	if (array[0].data) {
		root = array;
		root = copyTree(array);
		free(array);
	} else {
		root = NULL;
	}
	return root;
}

treeNode *copyTree(treeNode *tNode)
{
	treeNode *node;
	if (tNode) {
		node = newTreeNode();
		//out("%p\n", node);
		node->data = tNode->data; 
		node->lchild = copyTree(tNode->lchild);
		node->rchild = copyTree(tNode->rchild);
	} else {
		node = NULL;
	}
	return node;
}

treeNode *creatTreeStack()	//creat tree by a stack
{
	int x;
	treeNode *node;
	in("%d", &x);
	if (x) {
		node = newTreeNode();
		node->data = x;
		node->lchild = creatTreeStack();
		node->rchild = creatTreeStack();
	} else {
		node = NULL;
	}
	return node;
}

void printLevelNodeUser(treeNode *node)
{
	treeNode *p;
	stackNode *top;
	top = newStreeNode();
	p = node;
	while (p) {
		if (p->lchild) {
			pushTreeNode(top, p);
			p = p->lchild;
		}
		else {
			out("%d", p->data);
			popTreeNode(top, &p);
			if (p != NULL) {
				p = p->rchild;
			}
		}
	}
}