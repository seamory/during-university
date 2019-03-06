Attribute VB_Name = "图书馆时长统计"

'日期格式为yyyy-mm-dd hh:mm:ss

Sub 成绩统计()
Dim StudyID&, x1&, x3%, xt%, y%, i%, count% 
count = 1 
Do
StudyID = Sheet4.Cells(count, 1).Value
If StudyID = 0 Then Exit Do
x1 = 1 
x3 = 1 
Do
If Sheet1.Cells(x1, 1).Value = StudyID Then
Sheet3.Cells(x3, 1) = x3 'ID
Sheet3.Cells(x3, 2) = Sheet1.Cells(x1, 1).Value 
Sheet3.Cells(x3, 3) = Sheet1.Cells(x1, 2).Value
Sheet3.Cells(x3, 4) = Sheet1.Cells(x1, 3).Value
Sheet3.Cells(x3, 5) = Application.WorksheetFunction.Text(Mid(Sheet1.Cells(x1, 4).Value, 1, 10), "yyyymmdd")
Sheet3.Cells(x3, 6) = TimeValue(Mid(Sheet1.Cells(x1, 4).Value, 12, 8))
Sheet3.Cells(x3, 7) = Sheet1.Cells(x1, 5).Value
x3 = x3 + 1
End If
If x1 > 52026 Then Exit Do '修改最大数据上限
x1 = x1 + 1
Loop 
Sheet2.Cells(count, 1) = StudyID 
Sheet2.Cells(count, 2) = Sheet4.Cells(count, 2).Value 
Sheet2.Cells(count, 3) = Sheet3.Cells(1, 4).Value 
xt = 1 
i = 1 
Do While i < x3 
If Sheet3.Cells(i, 7).Value = "进" Then
i = i + 1
If Sheet3.Cells(i, 7).Value = "出" Then 
If Sheet3.Cells(i, 5).Value - Sheet3.Cells(i - 1, 5) = 0 Then 
Sheet3.Cells(xt, 8) = Sheet3.Cells(i, 6) - Sheet3.Cells(i - 1, 6)
i = i + 1
xt = xt + 1
End If 
End If
Else
i = i + 1
End If 
Loop 
Sheet3.Cells(1, 9) = Application.WorksheetFunction.Text(Application.WorksheetFunction.sum(Sheet3.Range("H:H")), "dd.hh:mm:ss")
Sheet2.Cells(count, 4) = "'" & Mid(Sheet3.Cells(1, 9), 1, 2) * 24 + Mid(Sheet3.Cells(1, 9), 4, 2) & ":" & Mid(Sheet3.Cells(1, 9), 7, 2) & ":" & Mid(Sheet3.Cells(1, 9), 10, 2) 
If Mid(Sheet3.Cells(1, 9), 1, 2) * 24 + Mid(Sheet3.Cells(1, 9), 4, 2) < 15 Then
Sheet2.Cells(count, 4).Interior.ColorIndex = 6 
End If
Sheet3.Range("A:I").ClearContents
count = count + 1
Loop
MsgBox ("统计数据完成")
End Sub
