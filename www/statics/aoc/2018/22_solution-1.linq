<Query Kind="Program" />

void Main()
{
	var input  = File.ReadAllLines(Path.Combine(Path.GetDirectoryName(Util.CurrentQueryPath), @"22_input.txt"));
	
	var depth  = long.Parse(input[0].Split(' ')[1]);
	(long x, long y) target = ( long.Parse(input[1].Split(' ')[1].Split(',')[0]), long.Parse(input[1].Split(' ')[1].Split(',')[1]) );

	long[,] map = new long[target.x + 1, target.y + 1]; // erosion_level

	for (long xx = 0; xx <= target.x; xx++) map[xx, 0] = ((xx * 16807) + depth) % 20183;
	for (long yy = 0; yy <= target.y; yy++) map[0, yy] = ((yy * 48271) + depth) % 20183;

	for (long x = 1; x <= target.x; x++)
	{
		for (long y = 1; y <= target.y; y++)
		{
			map[x, y] = ((map[x-1, y] * map[x, y-1]) + depth) % 20183;
		}
	}

	long risk = 0;
	for (long x = 0; x <= target.x; x++)
	{
		for (long y = 0; y <= target.y; y++)
		{
			if (x == 0 && y == 0) continue;
			if (x == target.x && y == target.y) continue;
			risk += map[x,y] % 3;
		}
	}

	risk.Dump();

	//StringBuilder b = new StringBuilder();
	//for (long y = 0; y <= target.y; y++)
	//{
	//	for (long x = 0; x <= target.x; x++)
	//	{
	//		if (map[x, y] % 3 == 0) b.Append('.');
	//		if (map[x, y] % 3 == 1) b.Append('=');
	//		if (map[x, y] % 3 == 2) b.Append('|');
	//	}
	//	b.AppendLine();
	//}
	//b.ToString().Dump();
}

// Define other methods and classes here
