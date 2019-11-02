<Query Kind="Program" />

class Command { public String Name; public (string, Action<int[], Command>) Op; public int[] Args; public int Dst => Args[2]; public int Arg1 => Args[0]; public int Arg2 => Args[1]; }

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
	(var commands, var ipidx) = Load(File.ReadAllLines(Path.Combine(Path.GetDirectoryName(Util.CurrentQueryPath), @"19_input.txt")));

	int[] data = new int[255];
	for (int gen=0;;gen++)
	{
		if (data[ipidx]<0 || data[ipidx]>=commands.Count) break;
		
		var cmd = commands[data[ipidx]];
		
		cmd.Op.Item2(data, cmd);
		//string.Join(" ", data.Take(6)).Dump();
		data[ipidx]++;
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
