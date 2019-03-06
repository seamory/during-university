#pragma once
extern "C" {
#include "struct.h"
}
#include <graphics.h>
#include<cstdlib>

extern "C" void showPic();
extern "C" void drawPath(int loc[256][3], int max, MGraph _G, long int length);