<Query Kind="Statements" />

var input = File.ReadAllText(Path.Combine(Path.GetDirectoryName(Util.CurrentQueryPath), @"14_input.txt")).Select(c => c-'0').Reverse().ToArray();


var board = new List<short>();
board.Add(3);
board.Add(7);

int elf1 = 0;
int elf2 = 1;
for (int gen = 0; ; gen++)
{
	var sum1 = board[elf1] + board[elf2];
	if (sum1 >= 10) board.Add(1); board.Add((short)(sum1 % 10));

	elf1 = (elf1 + 1 + board[elf1]) % board.Count;
	elf2 = (elf2 + 1 + board[elf2]) % board.Count;

	//board.Select((p, i) => (i == elf1) ? $"({p})" : ((i == elf2) ? $"[{p}]" : $" {p} ")).Aggregate((a,b)=>a+" "+b).Dump();

	if (board.Count >= input.Length && input.Select((p,i) => board[board.Count-1-i]==p  ).All(p=>p))
	{
		(board.Count-input.Length).Dump();
		return;
	}

	if (board.Count >= input.Length && sum1 >= 10 && input.Select((p, i) => board[board.Count - 2 - i] == p).All(p => p))
	{
		(board.Count - input.Length - 1).Dump();
		return;
	}
}