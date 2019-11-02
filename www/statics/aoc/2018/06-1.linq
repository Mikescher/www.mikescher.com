<Query Kind="Statements" />

var coords = File
	.ReadAllLines(Path.Combine(Path.GetDirectoryName(Util.CurrentQueryPath), @"06_input.txt"))
	.Where(p => !string.IsNullOrWhiteSpace(p))
	.Select(l => (int.Parse(l.Split(',')[0].Trim()), int.Parse(l.Split(',')[1].Trim())) )
	.ToList();


int[][] d = new int[2][];

for (int i = 0; i < 2; i++)
{
	var minX = coords.Min(p => p.Item1)-i;
	var maxX = coords.Max(p => p.Item1)+i;
	var minY = coords.Min(p => p.Item2)-i;
	var maxY = coords.Max(p => p.Item2)+i;

	int[,] map = new int[1+maxX-minX, 1+maxY-minY];

	d[i] = new int[coords.Count];

	for (int x = minX; x <= maxX; x++)
	for (int y = minX; y <= maxY; y++)
	{
		var s = coords.Select((c, idx) => new { I = idx, D = Math.Abs(c.Item1 - x) + Math.Abs(c.Item2 - y), V = c }).OrderBy(c => c.D).ToList();
		if (s[0].D == s[1].D) { map[x-minX, y-minY]=-1; continue; }
		d[i][s[0].I]++;
		map[x-minX, y-minY]=s[0].I;
	}
	//map.Dump();
}

//d[0].Zip(d[1], (a, b) => (a, b)).Dump();
d[0].Zip(d[1], (a, b) => (a, b)).Where(p => p.a == p.b).Max().a.Dump();