<Query Kind="Program" />

class Command 
{
	public int OpCode, Arg1, Arg2, Dst;
	public Command(int[] a) { OpCode=a[0];Arg1=a[1];Arg2=a[2];Dst=a[3]; }
}

(string, Action<int[], Command>)[] Operations = new (string, Action<int[], Command>)[]
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
	(var input1, var input2) = Load(File.ReadAllLines(Path.Combine(Path.GetDirectoryName(Util.CurrentQueryPath), @"16_input.txt")));

	input1.Count(ip => Operations.Count(op => Test(ip.Item1, op.Item2, ip.Item2, ip.Item3)) >= 3 ).Dump();
}

(List<(int[],Command,int[])>, List<Command>) Load(string[] lines)
{
	var r1 = new List<(int[], Command, int[])>();
	
	int i = 0;
	for (;; i+=4)
	{
		if (string.IsNullOrWhiteSpace(lines[i])) break;

		var a = lines[i + 0].Substring(8).TrimStart('[').TrimEnd(']').Split(',').Select(p => int.Parse(p.Trim())).ToArray();
		var b = new Command(lines[i + 1].Split(' ').Select(p => int.Parse(p.Trim())).ToArray());
		var c = lines[i + 2].Substring(8).TrimStart('[').TrimEnd(']').Split(',').Select(p => int.Parse(p.Trim())).ToArray();
		r1.Add( (a,b,c) );
	}

	for (; string.IsNullOrWhiteSpace(lines[i]); i++);

	var r2 = new List<Command>();
		
	for (; i < lines.Length; i++) r2.Add(new Command(lines[i].Split(' ').Select(p => int.Parse(p.Trim())).ToArray()));
	
	return (r1, r2);
}

bool ArrayEquals(int[] a, int[] b)
{
	if (a.Length != b.Length) return false;
	for (int i = 0; i < a.Length; i++) if (a[i] != b[i]) return false;
	return true;
}

bool Test(int[] before, Action<int[], Command> op, Command cmd, int[] after)
{
	var register=before.ToArray();
	op(register, cmd);

	if (register.Length != after.Length) return false;
	for (int i = 0; i < register.Length; i++) if (register[i] != after[i]) return false;
	return true;
}