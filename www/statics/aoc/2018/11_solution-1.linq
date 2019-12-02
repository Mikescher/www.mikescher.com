<Query Kind="Program" />

public int serial_num;

void Main()
{
	serial_num = int.Parse(File.ReadAllText(Path.Combine(Path.GetDirectoryName(Util.CurrentQueryPath), @"11_input.txt")));

	Enumerable
		.Range(1, 300-3)
		.SelectMany(x => Enumerable.Range(1, 300-3).Select(y => new {X=x, Y=y, Pow=SPow(x, y) }))
		.OrderByDescending(p => p.Pow)
		.Select(p => $"{p.X},{p.Y}")
		.First()
		.Dump();
}

int Pow(int x, int y) => (((x + 10) * ((x + 10) * y + serial_num) / 100) % 10) - 5;

int SPow(int x, int y) => Enumerable.Range(0, 9).Sum(v => Pow(x+v%3, y+v/3));
