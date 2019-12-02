<Query Kind="Statements" />

var input = int.Parse(File.ReadAllText(Path.Combine(Path.GetDirectoryName(Util.CurrentQueryPath), @"14_input.txt")));


var board = new List<int>(input);
board.Add(3);
board.Add(7);

int elf1 = 0;
int elf2 = 1;
for(int gen=0;;gen++)
{
	var sum1=board[elf1]+board[elf2];
	if (sum1>=10)board.Add(1); board.Add(sum1%10);

	elf1 = (elf1 + 1 + board[elf1]) % board.Count;
	elf2 = (elf2 + 1 + board[elf2]) % board.Count;

	//board.Select((p, i) => (i == elf1) ? $"({p})" : ((i == elf2) ? $"[{p}]" : $" {p} ")).Aggregate((a,b)=>a+" "+b).Dump();
	
	if (board.Count >= input+10) 
	{
		board.Skip(input).Take(10).Select(p=>p.ToString()).Aggregate((a,b)=>a+b).Dump();
		return;
	}
}