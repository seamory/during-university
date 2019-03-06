/*********************************
	*
	*	2016-12-16 18:48:56
	*	make by Brocade
	*	STUDENT DATA MANAGEMENT
	*
	********************************/

#include <stdio.h>
#include <stdlib.h>
#include <time.h>
#include <string.h>
#include <conio.h>
#include <windows.h>
#define L 20
#define SL 10
#define rst fflush(stdin)
#define cls system("cls")
#define pause fflush(stdin); getch()
#define out(...) printf(__VA_ARGS__)
#define in(...) while(scanf(__VA_ARGS__)!=1){ rst; puts("ERROR INPUT!");}
//#define pause while(getchar()!='\n'); getch()
//#define RST while(getchar()!='\n');

//	si studentinformation
//	ss studentstructure
typedef struct structure{
	int snum;
	char name[L];
	char sex[SL];
	int age;
	int grade;
	char class[L];
	char id[L];
}ss;

typedef struct si{
	struct structure ss;
	struct si *next;
}sim;

int menu(void);	//CREATE MENU
int ssmenu(void);	//CREATE STUDENT STRUCTURE
sim* creat(void);	//CREATE CHAIN TABLE
void get(sim *);	//GET CHAIN TABLE FROM FILE
void view(sim *);	//VIEW ALL  INFORMATIONS
void add(sim *);	//ADD INFORMATION
void delete(sim *);	//DELETE INFORMATION
void update(sim *);	//UPDATE INFORMATION
void updateplus(sim *);	//ADVANCED UPDATE
void query(sim *);	//QUERY INFORMATION
void queryplus(sim *);	//ADVANCED QUERY
void save(sim *);	//SAVE FILE FROM CHAIN TABLE
ss alterData(ss);   //CORE FUNCION OF UPDATE DATA
char *getTime(void);	//GET THE TIME FROM SYSTEM
void record(char * type);	//RECORD OPERATION OF USER

int main(void)
{
	sim *head;
	head=creat();
	get(head);
	system("title STUDENT INFORMATION MANAGEMENT");
	record("LOGIN");
	while(1)
		switch(menu())
		{
			case 1: view(head); break;
			case 2: add(head); break;
			case 3: delete(head); break;
			case 4: update(head); break;
			case 5: updateplus(head); break;
			case 6: query(head); break;
			case 7: queryplus(head); break;
			case 8: save(head); break;
			case 0: exit(1); break;
			default: out("ERROR");
		}
	return 0;
}

int menu(void)
{
	int x;
	do{
		cls;
		puts("1.view current datas");
		puts("2.add some new informations");
		puts("3.delete informations");
		puts("4.update informations");
		puts("5.advanced update");
		puts("6.query informations");
		puts("7.advanced query");
		puts("8.exit && save current data to file");
		puts("0.exit");
		in("%d", &x);
	}while( x<0 && x>8);
	return x;
}

int ssmenu(void)
{
	int x;
	do{
        puts("1.student number");
        puts("2.student name");
        puts("3.student sex");
        puts("4.student age");
        puts("5.student grade");
        puts("6.student class");
        puts("7.student id");
        //puts("0.exit");
        in("%d", &x);
	}while( x<1 && x>7);
	puts("Please input value");
	return x;
}

sim *creat()
{
	sim *node;
	node=(sim *)malloc(sizeof(sim));
	node->next=NULL;
	return node;
}

void get(sim *root)
{
	sim *last, *cur;
	FILE *fp;
	ss ss;
	last=root;
	if((fp=fopen("SBI.dat","rb"))==NULL)
	{
		out("OPEN THE DATA FILE ERROR! PLEASE CHEAK YOUR LIMITS OF AUTHORITY");
		pause;
		cls;
	}
	else
		while((fread(&ss,sizeof(ss),1,fp))==1)
		{
			cur=creat();
			cur->ss=ss;
			last->next=cur;
			last=cur;
		}
	fclose(fp);
}	//GET CHAIN TABLE FROM FILE

void view(sim *root)
{
	record("VIEW DATA");
    cls;
	sim *cur;
	cur=root;
	cur=cur->next;
	if(cur==NULL)
		out("EMPTY CHAIN TABLE AT PRESENT");
	else
	{
		out("snum\t name\t sex\t age\t grade\t class\t id\n");
		while(cur!=NULL)
		{
			out("%d\t %s\t %s\t %d\t %d\t %s\t %s\n", cur->ss.snum, cur->ss.name, cur->ss.sex, cur->ss.age, cur->ss.grade, cur->ss.class, cur->ss.id);
			cur=cur->next;
		}
	}
	pause;
}	//VIEW ALL  INFORMATIONS

void add(sim *root)
{
	record("ADDPEND NEW DATA");
	sim *last, *cur;
	ss ss;
	char x='Y';
	last=root;
	while(last->next!=NULL)
		last=last->next;
	do{
		cls;
		puts("Please input the student number");
		in("%d", &ss.snum);
		puts("Please input the student's name");
		in("%s", &ss.name);
		puts("Please input the student's sex");
		in("%s", &ss.sex);
		puts("Please input the student's age");
		in("%d", &ss.age);
		puts("Please input the student's grade");
		in("%d", &ss.grade);
		puts("Please input the student's class");
		in("%s", &ss.class);
		puts("Please input the student's id");
		in("%s", &ss.id);
		cur=creat();
		cur->ss=ss;
		last->next=cur;
		last=cur;
		rst;
		puts("DO YOU WANT TO CONTINUE?(Y/N)");
		in("%c", &x);
	}while(toupper(x)!='N');
}	//ADD INFORMATION

void delete(sim *root)
{
	record("DELETE DATA");
	cls;
	sim *cur, *rls;
	int sn, i=0;
	cur=root;
	rls=cur->next;
	puts("Please input the student number to delete data.");
	in("%d", &sn);
	while(rls!=NULL)
	{
		if(rls->ss.snum==sn)
		{
			cur->next=cur->next->next;
			free(rls);
			rls=NULL;
			out("%p\n", cur);
			i++;
		}
		if(rls==NULL)
        {
			rls=cur->next;
        }
		else
        {
			rls=rls->next;
            cur=cur->next;
        }
	}
	if(i==0)
		puts("Delete failed!");
	else
		out("Delete success, affected %d user's data", i);
	pause;
}	//DELETE INFORMATION

void update(sim *root)
{
	record("UPDATE DATA");
	cls;
	ss ss;
	sim *cur;
	int sn, i=0;
	cur=root->next;
	puts("Please input the student number to update data");
	in("%d", &sn);
	while(cur!=NULL)
		if(cur->ss.snum==sn)
		{
			ss=cur->ss;
			ss=alterData(ss);
			cur->ss=ss;
			cur=cur->next;
			i++;
		}
		else
			cur=cur->next;
	if(i==0)
		puts("No user's data to update");
	else
		out("Update data success, affected %d data\n", i);
	pause;
}	//UPDATE INFORMATION

ss alterData(ss temp)
{
	ss rss; //rss return student structure
	rss=temp;
	puts("please chose a property which you want to alter.");
	switch(ssmenu())
	{
		//case 0: return rss; break;
		case 1: in("%d", &rss.snum); break;
		case 2: in("%s", &rss.name); break;
		case 3: in("%s", &rss.sex); break;
		case 4: in("%d", &rss.age); break;
		case 5: in("%d", &rss.grade); break;
		case 6: in("%s", &rss.class); break;
		case 7: in("%s", &rss.id); break;
		default: puts("ERROR!");
	}
	//puts("ALTER DATA SUCCESS!");
	return rss;
}

void query(sim *root)
{
	record("QUERY DATA");
    cls;
	sim *cur;
	int sn, i=0;
	cur=root->next;
	puts("Please input the student number to query.");
	in("%d", &sn);
	while(cur!=NULL)
		if(cur->ss.snum==sn)
        {
			out("%d\t %s\t %s\t %d\t %d\t %s\t %s\n", cur->ss.snum, cur->ss.name, cur->ss.sex, cur->ss.age, cur->ss.grade, cur->ss.class, cur->ss.id);
			cur=cur->next;
			i++;
        }
		else
			cur=cur->next;
	if(i==0)
		puts("No user's data");
    pause;
}	//QUERY INFORMATION

void updateplus(sim *root)
{
	record("UPDATE DATA BY ADVANCED FUNCTION");
	cls;
	sim *cur;
	int i=0;
	ss ss, tss, t={1,"0","0",0,0,"0","0"}; //ss student structure. tss temp student strcuture. t temp;
	cur=root->next;
	puts("Please chose a select which you want to update by.");
	switch(ssmenu())
	{
		case 1: in("%d", &ss.snum); break;
		case 2: in("%s", &ss.name); break;
		case 3: in("%s", &ss.sex); break;
		case 4: in("%d", &ss.age); break;
		case 5: in("%d", &ss.grade); break;
		case 6: in("%s", &ss.class); break;
		case 7: in("%s", &ss.id); break;
		case 0: t.snum=0; return; break;
		default: puts("ERROR!");
	}
	if(t.snum)
        while(cur!=NULL)
        {
            strcpy(t.name,cur->ss.name);
            strcpy(t.sex,cur->ss.sex);
            strcpy(t.class,cur->ss.class);
            strcpy(t.id,cur->ss.id);
            if(cur->ss.snum==ss.snum || strcmp(t.name,ss.name)==0 || strcmp(t.sex,ss.sex)==0 || cur->ss.age==ss.age || cur->ss.grade==ss.grade || strcmp(t.class,ss.class)==0 || strcmp(t.id,ss.id)==0)
                {
					tss=cur->ss;
					tss=alterData(tss);
					cur->ss=tss;
					cur=cur->next;
					i++;
                }
                else
                    cur=cur->next;
        }
	if(i==0)
		puts("No user's data to update");
	else
		out("Update data success, affected %d data\n", i);
	pause;
}

void queryplus(sim *root)
{
	record("QUERY DATA BY ADVANCED FUNCTION");
	cls;
	sim *cur;
	int i=0;
	ss ss, t={1,"0","0",0,0,"0","0"};
	//ss.age=1;
	cur=root->next;
	puts("Please chose a select which you want to query by.");
	switch(ssmenu())
	{
		case 1: in("%d", &ss.snum); break;
		case 2: in("%s", &ss.name); break;
		case 3: in("%s", &ss.sex); break;
		case 4: in("%d", &ss.age); break;
		case 5: in("%d", &ss.grade); break;
		case 6: in("%s", &ss.class); break;
		case 7: in("%s", &ss.id); break;
		case 0: t.snum=0; return; break;
		default: puts("ERROR!");
	}
	if(t.snum)
        while(cur!=NULL)
        {
            strcpy(t.name,cur->ss.name);
            strcpy(t.sex,cur->ss.sex);
            strcpy(t.class,cur->ss.class);
            strcpy(t.id,cur->ss.id);
            if(cur->ss.snum==ss.snum || strcmp(t.name,ss.name)==0 || strcmp(t.sex,ss.sex)==0 || cur->ss.age==ss.age || cur->ss.grade==ss.grade || strcmp(t.class,ss.class)==0 || strcmp(t.id,ss.id)==0)
                {
                    out("%d\t %s\t %s\t %d\t %d\t %s\t %s\n", cur->ss.snum, cur->ss.name, cur->ss.sex, cur->ss.age, cur->ss.grade, cur->ss.class, cur->ss.id);
                    cur=cur->next;
					i++;
                }
                else
                    cur=cur->next;
        }
	if(i==0)
		puts("No user's data.");
	pause;
}

void save(sim *root)
{
	record("SAVE DATA FILE AND LOGOUT SUCCESS");
	sim *cur;
	FILE *fp;
	ss ss;
	remove("SBI.dat");
	fp=fopen("SBI.dat", "wb");
	cur=root->next;
	while(cur!=NULL)
	{
		fwrite(&cur->ss,sizeof(ss),1,fp);
		cur=cur->next;
	}
	out("SAVE SUCCESS! EXIT AFTER 3 SECONDS");
	fclose(fp);
    Sleep(3000);
	exit(0);
}	//SAVE FILE FROM CHAIN TABLE

char *getTime(void)
{
	char *parameter;
	struct tm* ptr;
	time_t localTime;
	time(&localTime);
	ptr=localtime(&localTime);
	parameter=asctime(ptr);
	return parameter;
}

void record(char *type)
{
	int i=0;
	char time[50], *temp;
	FILE *fp;
	temp=getTime();
	strcpy(time,temp);
	while(time[i])
	{
		if(time[i]=='\n')
		{
			time[i]='\0';
			break;
		}
		i++;
	}
	if((fp=fopen("log.dat", "a+"))==NULL)
	{
		puts("OPEN FILE ERROR");
		puts("EXIT AFTER 3 SCENDS");
		Sleep(3000);
		exit(1);
	}
	else
		fprintf(fp,"%s\t:\t%s ;\n", time, type);
    fclose(fp);
}
