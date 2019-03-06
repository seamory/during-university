Attribute VB_Name = "图书馆时长统计"

'日期格式为yyyy-mm-dd hh:mm:ss

Sub 成绩统计()
Dim StudyID&, x1&, x3%, xt%, y%, i%, count% ' 声明变量
count = 1 '起始数据位置
Do
StudyID = Sheet4.Cells(count, 1).Value
If StudyID = 0 Then Exit Do
x1 = 1 'sheet1数据区搜索起始位置
x3 = 1 'sheet3工作区建立起始位置
Do
If Sheet1.Cells(x1, 1).Value = StudyID Then
Sheet3.Cells(x3, 1) = x3 'ID
Sheet3.Cells(x3, 2) = Sheet1.Cells(x1, 1).Value '学号
Sheet3.Cells(x3, 3) = Sheet1.Cells(x1, 2).Value '姓名
Sheet3.Cells(x3, 4) = Sheet1.Cells(x1, 3).Value '专业年级
Sheet3.Cells(x3, 5) = Application.WorksheetFunction.Text(Mid(Sheet1.Cells(x1, 4).Value, 1, 10), "yyyymmdd") '进出日期
Sheet3.Cells(x3, 6) = TimeValue(Mid(Sheet1.Cells(x1, 4).Value, 12, 8)) '进出时间
Sheet3.Cells(x3, 7) = Sheet1.Cells(x1, 5).Value '进出
x3 = x3 + 1
End If
If x1 > 52026 Then Exit Do '修改最大数据上限
x1 = x1 + 1
Loop '原始数据表搜索数据结束
Sheet2.Cells(count, 1) = StudyID '存储单元学号
Sheet2.Cells(count, 2) = Sheet4.Cells(count, 2).Value '存储单元姓名
Sheet2.Cells(count, 3) = Sheet3.Cells(1, 4).Value '存储单元年级
'Loop '创建储存单元结束
xt = 1 '工作区时间计算起始行位置
i = 1 '工作区循环起始位置
Do While i < x3 'sheet3数据个数
If Sheet3.Cells(i, 7).Value = "进" Then
i = i + 1
If Sheet3.Cells(i, 7).Value = "出" Then '判断进出状态
If Sheet3.Cells(i, 5).Value - Sheet3.Cells(i - 1, 5) = 0 Then '判断是否跨天刷卡
Sheet3.Cells(xt, 8) = Sheet3.Cells(i, 6) - Sheet3.Cells(i - 1, 6)
i = i + 1
xt = xt + 1
End If '结束判断跨天刷卡
End If
Else
i = i + 1
End If '结束判断进出状态
Loop '工作区计算时长结束
'Sheet2.Cells(count, 4) = Application.WorksheetFunction.sum(Sheet3.Range("H:H")) '数据区保存
Sheet3.Cells(1, 9) = Application.WorksheetFunction.Text(Application.WorksheetFunction.sum(Sheet3.Range("H:H")), "dd.hh:mm:ss") '计算在馆时长并确定格式，存储数据至工作区
Sheet2.Cells(count, 4) = "'" & Mid(Sheet3.Cells(1, 9), 1, 2) * 24 + Mid(Sheet3.Cells(1, 9), 4, 2) & ":" & Mid(Sheet3.Cells(1, 9), 7, 2) & ":" & Mid(Sheet3.Cells(1, 9), 10, 2) '显示格式修正为HH:MM:SS形式并保存到存储区
If Mid(Sheet3.Cells(1, 9), 1, 2) * 24 + Mid(Sheet3.Cells(1, 9), 4, 2) < 15 Then
Sheet2.Cells(count, 4).Interior.ColorIndex = 6 '时长小于15小时，单元格高亮显示
End If
Sheet3.Range("A:I").ClearContents '清除工作区
count = count + 1 '逐次建立数据
Loop '历遍循环结束
MsgBox ("统计数据完成")
End Sub
