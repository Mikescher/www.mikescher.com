<Query Kind="Program" />

void Main()
{
	var input = File.ReadAllText(Path.Combine(Path.GetDirectoryName(Util.CurrentQueryPath), @"09_input.txt"));

	var players = int.Parse(input.Split(' ')[0]);
	var marbles = int.Parse(input.Split(' ')[6]);

	List<int> board = new List<int> { 0 };
	int[] score = new int[players];

	int curr = 0;
	int currplayer = 0;
	for (int m = 1; m <= marbles; m++)
	{
		if (m % 23 != 0)
		{
			curr = (curr + 2)%board.Count;
			board.Insert(curr, m);
		}
		else
		{
			score[currplayer] += m;
			curr = (board.Count + curr - 7) % board.Count;
			score[currplayer] += board[curr];
			board.RemoveAt(curr);
		}

		//($"[{currplayer+1:0}]" + string.Join(" ", board.Select((b, i) => i == curr ? $"({b:00})" : $" {b:00} "))).Dump();

		currplayer = (currplayer + 1) % players;
	}

	score.Max().Dump();
}
