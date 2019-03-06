#pragma once
#ifndef TREE
#define TREE

#include  "initHead.h"

typedef struct tNode {
	struct tNode *lchild;
	int data;
	struct tNode *rchild;
} treeNode;

typedef struct sNode {
	struct tNode *node;
	struct sNode *next;
} stackNode;

typedef struct qNode {
	struct tNode *node;
	struct qNode *next;
} queueNode;

stackNode *newStreeNode(void);
void pushTreeNode(stackNode *top,treeNode *node);
bool popTreeNode(stackNode *top, treeNode **node);
bool emptyTreeStack(stackNode *top);

queueNode *newQtreeNode();
void inTreeNode(queueNode **rear, treeNode *node);
bool outTreeNode(queueNode *front, queueNode **rear, treeNode **node);
bool emptyTreeQueue(queueNode *front);
int countTreeQueue(queueNode *front);

treeNode *newTreeNode(void);
treeNode *creatTree(void);
treeNode *creatTreeStack(void);
treeNode *copyTree(treeNode *tNode);
void printLevelNodeUser(treeNode *node);	//使用用户栈输出叶子结点

#endif // !TREE
