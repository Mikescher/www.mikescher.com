<Query Kind="Program" />

void Main()
{
	var b = 10551358;
	var a = 0;
	for (int i = 1; i <= b; i++) if (b % i == 0)a+=i;
	a.Dump();
}

/*
 [1-ORIGINAL]           [2-SYNTAX]           [3-RESOLVE]         [4-SIMPLIFY]

#ip 1
00: addi 1 16 1           [1]=[1]+16            JMP 17             JMP 17                         
01: seti 1 5 5            [5]=1                                1:  E := 1                         
02: seti 1 2 3            [3]=1                                2:  C := 1                         
03: mulr 5 3 2            [2]=[3]*[5]                          3:  B := C*E                       
04: eqrr 2 4 2            [2]=([2]==[4])                           if (B = D) A += E              
05: addr 2 1 1            [1]=[2]+[1]           JMP 6+[2]                                         
06: addi 1 1 1            [1]++                 JMP 8                                             
07: addr 5 0 0            [0]=[5]+[0]                                                             
08: addi 3 1 3            [3]++                                    C++                            
09: gtrr 3 4 2            [2]=([3]>[4])                            if (C<=D) JUMP 3               
10: addr 1 2 1            [1]=[1]+[2]           JMP 11+[2]                                        
11: seti 2 6 1            [1]=2                 JMP 3                                             
12: addi 5 1 5            [5]++                                    E++                            
13: gtrr 5 4 2            [2]=([5]>[4])                            if (E<=D) JUMP 2 else EXIT     
14: addr 2 1 1            [1]=[1]+[2]           JMP 15+[2]                                        
15: seti 1 8 1            [1]=1                 JMP 2                                             
16: mulr 1 1 1            [1]=[1]*[1]           EXIT                                              
17: addi 4 2 4            [4]+=2                              17:  D+=2                          |
18: mulr 4 4 4            [4]=[4]*[4]                              D=D*D                         |
19: mulr 1 4 4            [4]=[4]*[1]           [4]=[4]*19         D*=19                         |
20: muli 4 11 4           [4]=[4]*[1]           [4]=[4]*11         D*=11                         |
21: addi 2 5 2            [2]=[2]+5                                B+=5                          |
22: mulr 2 1 2            [2]=[2]*[1]           [2]=[2]*22         B*=22                         |
23: addi 2 12 2           [2]=[2]+12                               B+=12                         |B := 122
24: addr 4 2 4            [4]=[4]+[2]                              D+=B                          |D := 958
25: addr 1 0 1            [1]=[1]+[0]           JMP 26+[0]         if (A = 0) JUMP 1              
26: seti 0 4 1            [1]=0                 JMP 1                                             
27: setr 1 4 2            [2]=[1]               [2]=[4]+27         B=27                          |
28: mulr 2 1 2            [2]=[2]*[1]           [2]=[2]*28         B=B*28                        |
29: addr 1 2 2            [2]=[2]+[1]           [2]=[2]+29         B=B+29                        |
30: mulr 1 2 2            [2]=[2]*[1]           [2]=[2]*30         B=B*30                        |
31: muli 2 14 2           [2]=[2]*14                               B=B*14                        |
32: mulr 2 1 2            [2]=[2]*[1]           [2]=[2]*32         B=B*32                        |B := 10550400
33: addr 4 2 4            [4]=[2]+[4]                              D=B+D                         |D := 10551358
34: seti 0 3 0            [0]=0                                    A=0                            
35: seti 0 7 1            [1]=0                 JMP 1              JUMP 1                         




[5-SHRINK]

     JMP 17
 1:  E := 1
 2:  C := 1
 3:  B := C*E
     if (B = D) A += E
     C++
     if (C<=D) JUMP 3
     E++
     if (E<=D) JUMP 2 else EXIT
17:  B = 122
     D = 958
     if (A = 0) JUMP 1
     B = 10550400
     D = 10551358
     A=0
     JUMP 1




[6-REORDER]

if (A=0) 
    B = 122; D = 958
else
    B = 10550400; D = 10551358;

A = 0

    E=1
S1: C=1
S2:     B=C*E
        if (B = D) A += E
        C++
        if (C<=D) JUMP S2
        E++
    if (E<=D)
        JUMP S1
    else
        EXIT




[7-LANGUAGE]

if (A=0) B = 122;      D = 958;
else     B = 10550400; D = 10551358;

A = 0
E = 1

do
{
	C=1
	do
	{
		B=C*E
		if (B == D) A += E
		C++
	}
	while (C <= D)
	E++
}
while (E <= D)




[8-SUGAR]

if (A=0) B = 122;      D = 958;
else     B = 10550400; D = 10551358;

A = 0
E = 1

for(E=1; E<=D; E++)
{
	for(C=1; C<=D; C++)
	{
		if (C*E == D) A += E
	}
}




[9-EXPLANATION]

THE SUM OF ALL FACTORS OF 10551358

*/
