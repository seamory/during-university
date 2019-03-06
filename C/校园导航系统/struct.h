#pragma once
#include "variable.h"

 typedef struct {
	int adj; // 相邻接的景点之间的路程
	char *info;
} ArcCell; // 定义边的类型 

typedef struct {
	int number; // 位置编号 
	char *sight; // 位置名称
	char *describle;
	int x;
	int y;
} VertexType; // 定义顶点的类型 

typedef struct
{
	VertexType vex[NUM];
	ArcCell arcs[NUM][NUM];
	int vexnum;
	int arcnum;
} MGraph; // 定义图的类型

struct student
{
	char name[20];
	char secret[20];
};

struct student stu[N];
MGraph G;
int P[NUM][NUM]; 
long int D[NUM];
int n;