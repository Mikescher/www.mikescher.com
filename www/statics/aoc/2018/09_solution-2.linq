<Query Kind="Program" />

class Marble { public Marble Prev, Next; public int Value; }

void Main()
{
	var input = File.ReadAllText(Path.Combine(Path.GetDirectoryName(Util.CurrentQueryPath), @"09_input.txt"));

	var players = int.Parse(input.Split(' ')[0]);
	var marbles = int.Parse(input.Split(' ')[6]) * 100;

	List<int> board = new List<int> { 0 };
	long[] score = new long[players];

	Marble curr = new Marble();
	curr.Next = curr;
	curr.Prev = curr;

	int currplayer = 0;
	Marble old = null;
	for (int m = 1; m <= marbles; m++)
	{
		if (m % 23 != 0)
		{
			curr = curr.Next;
			var nm = old ?? new Marble();
			old=null;
			nm.Prev=curr;
			nm.Next=curr.Next;
			nm.Value=m;
			curr.Next.Prev = nm;
			curr.Next = nm;
			curr = curr.Next;
		}
		else
		{
			score[currplayer] += m;
			curr = curr.Prev.Prev.Prev.Prev.Prev.Prev;
			score[currplayer] += curr.Prev.Value;
			
			old = curr.Prev;
			var c = old.Prev;
			c.Next = curr;
			curr.Prev=c;
		}

		//($"[{currplayer+1:0}]" + string.Join(" ", board.Select((b, i) => i == curr ? $"({b:00})" : $" {b:00} "))).Dump();

		currplayer = (currplayer + 1) % players;

		Util.Progress = (m * 100) / marbles;
	}

	score.Max().Dump();
}
