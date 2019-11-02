<Query Kind="Program" />

class Command
{
	public int OpCode, Arg1, Arg2, Dst;
	public Command(int[] a) { OpCode = a[0]; Arg1 = a[1]; Arg2 = a[2]; Dst = a[3]; }
}

(string, Action<int[], Command>)[] Operations = new(string, Action<int[], Command>)[]
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

	var mapping = GenerateMapping(input1);

	int[] data = new int[128];
	foreach (var cmd in input2) mapping[cmd.OpCode].Item2(data, cmd);
	data[0].Dump();
}

(List<(int[], Command, int[])>, List<Command>) Load(string[] lines)
{
	var r1 = new List<(int[], Command, int[])>();

	int i = 0;
	for (; ; i += 4)
	{
		if (string.IsNullOrWhiteSpace(lines[i])) break;

		var a = lines[i + 0].Substring(8).TrimStart('[').TrimEnd(']').Split(',').Select(p => int.Parse(p.Trim())).ToArray();
		var b = new Command(lines[i + 1].Split(' ').Select(p => int.Parse(p.Trim())).ToArray());
		var c = lines[i + 2].Substring(8).TrimStart('[').TrimEnd(']').Split(',').Select(p => int.Parse(p.Trim())).ToArray();
		r1.Add((a, b, c));
	}

	for (; string.IsNullOrWhiteSpace(lines[i]); i++) ;

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
	var register = before.ToArray();
	op(register, cmd);

	if (register.Length != after.Length) return false;
	for (int i = 0; i < register.Length; i++) if (register[i] != after[i]) return false;
	return true;
}

(string, Action<int[], Command>)[] GenerateMapping(List<(int[], Command,int[])> input)
{
	var mapping = Enumerable
		.Range(0,16)
		.Select(p => Operations.ToList() )
		.ToArray();
		
	foreach (var test in input)
	{
		if (mapping[test.Item2.OpCode].Count == 1) { Assert(Test(test.Item1, mapping[test.Item2.OpCode][0].Item2, test.Item2, test.Item3)); continue;}
		
		mapping[test.Item2.OpCode] = mapping[test.Item2.OpCode].Where(op => Test(test.Item1, op.Item2, test.Item2, test.Item3)).ToList();
		Assert(mapping[test.Item2.OpCode].Any());
	}
	
	for (int i_ = 0; i_ < 16; i_++)
	{
		foreach (var rm in mapping.Select((m,i) => (m,i)).Where(m => m.m.Count==1).ToList())
		{
			for (int j = 0; j < 16; j++)
			{
				if (j==rm.i) continue;
				mapping[j] = mapping[j].Where(m => m.Item1 != rm.m.Single().Item1).ToList();
			}
		}
	}

	Assert(mapping.Select(p => p.Single().Item1).Distinct().Count() == 16);

	return mapping.Select(p => p.Single()).ToArray();
}

void Assert(bool b) { if (!b) throw new Exception(); }