<Query Kind="Statements" />

var coords = File
	.ReadAllLines(Path.Combine(Path.GetDirectoryName(Util.CurrentQueryPath), @"06_input.txt"))
	.Where(p => !string.IsNullOrWhiteSpace(p))
	.Select(l => (int.Parse(l.Split(',')[0].Trim()), int.Parse(l.Split(',')[1].Trim())))
	.ToList();


var minX = coords.Min(p => p.Item1) - 5_000;
var maxX = coords.Max(p => p.Item1) + 5_000;
var minY = coords.Min(p => p.Item2) - 5_000;
var maxY = coords.Max(p => p.Item2) + 5_000;

int r = 0;

for (int x = minX; x <= maxX; x++)
for (int y = minX; y <= maxY; y++)
{
	var s1 = coords.Sum(c => Math.Abs(c.Item1 - x) + Math.Abs(c.Item2 - y));
	if (s1 < 10_000) r++;
	Util.Progress=((x-minX)*100)/(maxX-minX);
}

r.Dump();