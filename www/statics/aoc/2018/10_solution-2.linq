<Query Kind="Program" />

class P { public int XX, YY, VX, VY; }

List<P> input;

void Main()
{
	input = File
		.ReadAllLines(Path.Combine(Path.GetDirectoryName(Util.CurrentQueryPath), @"10_input.txt"))
		.Where(p => !string.IsNullOrWhiteSpace(p))
		.Select(l => new P
		{
			XX = int.Parse(l.Substring(10, 6).Trim()),
			YY = int.Parse(l.Substring(18, 6).Trim()),
			VX = int.Parse(l.Substring(36, 2).Trim()),
			VY = int.Parse(l.Substring(40, 2).Trim()),
		})
		.ToList();



	for (int i = 1; ; i++)
	{
		foreach (var v in input) { v.XX += v.VX; v.YY += v.VY; }


		if (input.Any(Alone)) continue;
		//Print();
		i.Dump();
		return;
	}

}

bool Alone(P p) => !input.Any(i => i != p && Math.Abs(i.XX - p.XX) <= 1 && Math.Abs(i.YY - p.YY) <= 1);

void Print()
{
	int minX = input.Min(i => i.XX);
	int maxX = input.Max(i => i.XX);
	int minY = input.Min(i => i.YY);
	int maxY = input.Max(i => i.YY);

	var b = new StringBuilder();
	for (int y = minY; y <= maxY; y++)
	{
		for (int x = minX; x <= maxX; x++)
		{
			b.Append(input.Any(i => i.XX == x && i.YY == y) ? '#' : '.');
		}
		b.AppendLine();
	}
	b.ToString().Dump();

}
