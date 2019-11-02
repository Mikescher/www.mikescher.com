<Query Kind="Program" />

class Command { public String Name; public (string, Action<long[], Command>) Op; public int[] Args; public int Dst => Args[2]; public int Arg1 => Args[0]; public int Arg2 => Args[1]; }

(string, Action<long[], Command>)[] Operations = new(string, Action<long[], Command>)[]
{
	("addr", (reg, cmd) => { reg[cmd.Dst] = reg[cmd.Arg1] + reg[cmd.Arg2];        } ),
	("addi", (reg, cmd) => { reg[cmd.Dst] = reg[cmd.Arg1] +     cmd.Arg2;         } ),
	("mulr", (reg, cmd) => { reg[cmd.Dst] = reg[cmd.Arg1] * reg[cmd.Arg2];        } ),
	("muli", (reg, cmd) => { reg[cmd.Dst] = reg[cmd.Arg1] *     cmd.Arg2;         } ),
	("banr", (reg, cmd) => { reg[cmd.Dst] = reg[cmd.Arg1] & reg[cmd.Arg2];        } ),
	("bani", (reg, cmd) => { reg[cmd.Dst] = reg[cmd.Arg1] &     cmd.Arg2;         } ),
	("borr", (reg, cmd) => { reg[cmd.Dst] = reg[cmd.Arg1] | reg[cmd.Arg2];        } ),
	("bori", (reg, cmd) => { reg[cmd.Dst] = reg[cmd.Arg1] |     cmd.Arg2;         } ),
	("setr", (reg, cmd) => { reg[cmd.Dst] = reg[cmd.Arg1];                        } ),
	("seti", (reg, cmd) => { reg[cmd.Dst] =     cmd.Arg1;                         } ),
	("gtir", (reg, cmd) => { reg[cmd.Dst] =     cmd.Arg1  >  reg[cmd.Arg2] ? 1:0; } ),
	("gtri", (reg, cmd) => { reg[cmd.Dst] = reg[cmd.Arg1] >      cmd.Arg2  ? 1:0; } ),
	("gtrr", (reg, cmd) => { reg[cmd.Dst] = reg[cmd.Arg1] >  reg[cmd.Arg2] ? 1:0; } ),
	("eqir", (reg, cmd) => { reg[cmd.Dst] =     cmd.Arg1  == reg[cmd.Arg2] ? 1:0; } ),
	("eqri", (reg, cmd) => { reg[cmd.Dst] = reg[cmd.Arg1] ==     cmd.Arg2  ? 1:0; } ),
	("eqrr", (reg, cmd) => { reg[cmd.Dst] = reg[cmd.Arg1] == reg[cmd.Arg2] ? 1:0; } ),
};

void Main()
{
	(var commands, var ipidx) = Load(File.ReadAllLines(Path.Combine(Path.GetDirectoryName(Util.CurrentQueryPath), @"21_input.txt")));

	long[] data = new long[6];
	data[0]=2;
	for (int gen=0;;gen++)
	{
		if (data[ipidx] < 0 || data[ipidx] >= commands.Count) { break; }
		
		var ip=data[ipidx];
		var cmd = commands[(int)ip];

		if (ip == 28) { data[4].Dump(); return; } // this is   if ([4] == [0]) EXIT

		cmd.Op.Item2(data, cmd);
		data[ipidx]++;

		//$"{ip:00}:{cmd.Op.Item1}  [{string.Join(" ", data.Take(6).Select(i => $"{i,-10}"))}]".Dump();
	}
	
	data[0].Dump();
}

(List<Command>, int) Load(string[] input)
{
	return
	(
		input
			.Skip(1)
			.Where(i => !string.IsNullOrWhiteSpace(i))
			.Select(i => new Command { Name = i.Split(' ')[0], Op=Operations.Single(o => o.Item1.ToLower() == i.Split(' ')[0].ToLower()), Args = i.Split(' ').Skip(1).Select(int.Parse).ToArray() })
			.ToList(),
		int.Parse(input[0].Split(' ')[1])
	);
}

/*

#ip 1
00: seti 123 0 4          [4] = 123                   [4] =  123                        [4] =  123
01: bani 4 456 4          [4] = [4] & 456         1:  [4] &= 456                        [4] &= 456
02: eqri 4 72 4           [4] = [4] == 72             if ([4]<>72) JMP 1                if ([4]<>72) ERROR
03: addr 4 1 1            IP  = IP + [4]                                                
04: seti 0 0 1            IP  = 0                                                                                                  
05: seti 0 2 4            [4] = 0                     [4] =  0                          [4] =  0                                   for([4] =  0;;)
06: bori 4 65536 3        [3] = [4] | 65536       6:  [3] =  [4] | 65536            6:  [3] =  [4] | 65536                             [3] =  [4] | 65536 
07: seti 10552971 1 4     [4] = 10552971              [4] =  10552971                   [4] =  10552971                                [4] =  10552971
08: bani 3 255 5          [5] = [3] & 255         8:  [5] =  [3] & 255              8:  [5] =  [3] & 255                               for(;;)
09: addr 4 5 4            [4] = [4] + [5]             [4] += [5]                        [4] += [5]                                         [5] =  [3] & 255
10: bani 4 16777215 4     [4] = [4] & 16777215        [4] &= 16777215                   [4] &= 16777215                                    [4] += [5]
11: muli 4 65899 4        [4] = [4] * 65899           [4] *= 65899                      [4] *= 65899                                       [4] &= 16777215 
12: bani 4 16777215 4     [4] = [4] & 16777215        [4] &= 16777215                   [4] &= 16777215                                    [4] *= 65899    
13: gtir 256 3 5          [5] = 256 > [3]             if (256 > [3]) JMP 28             if (256 > [3] && [4] == [0]) EXIT                  [4] &= 16777215 
14: addr 5 1 1            IP  = IP + [5]                                                if (256 > [3]) JMP 6                               if (256 > [3] && [4] == [0]) EXIT
15: addi 1 1 1            IP  = IP + 1                                                                                                     if (256 > [3])  BREAK
16: seti 27 7 1           IP  = 27                                                                                                 
17: seti 0 1 5            [5] = 0                     [5] =  0                          [5] =  0                                           
18: addi 5 1 2            [2] = [5] + 1          18:  [2] =  [5] + 1               18:  [2] =  [5] + 1                                     for([5]=0;;)
19: muli 2 256 2          [2] = [2] * 256             [2] *= 256                        [2] *= 256                                             [2] =  ([5] + 1) * 256  
20: gtrr 2 3 2            [2] = [2] > [3]             if ([2] > [3]) JMP 26             if ([2] > [3]) [3] = [5]; JMP 8                        
21: addr 2 1 1            IP  = IP + [2]                                                else           [5]++      JMP 18                       if ([2] > [3]) [3] = [5]; BREAK
22: addi 1 1 1            IP  = IP + 1                                                                                                         else           [5]++      CONTINUE
23: seti 25 0 1           IP  = 25                                                      
24: addi 5 1 5            [5] = [5] + 1               [5]++                             
25: seti 17 2 1           IP  = 17                    JMP 18                            
26: setr 5 7 3            [3] = [5]              26:  [3] = [5]                    
27: seti 7 8 1            IP  = 7                     JMP 8                        
28: eqrr 4 0 5            [5] = [4] == [0]       28:  if ([4] == [0]) EXIT         
29: addr 5 1 1            IP  = IP + [5]              else JMP 6                   
30: seti 5 0 1            IP  = 5                                                  

*/
