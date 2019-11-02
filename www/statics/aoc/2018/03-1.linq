<Query Kind="Expression" />

File
	.ReadAllLines(Path.Combine(Path.GetDirectoryName(Util.CurrentQueryPath), @"03_input.txt"))
	.Where(l => !string.IsNullOrWhiteSpace(l))
	.Select(l => new
	{
		ID = int.Parse(l.Substring(1).Split(' ')[0]),
		X = int.Parse(l.Split('@')[1].Split(':')[0].Split(',')[0].Trim()),
		Y = int.Parse(l.Split('@')[1].Split(':')[0].Split(',')[1].Trim()),
		W = int.Parse(l.Split('@')[1].Split(':')[1].Split('x')[0].Trim()),
		H = int.Parse(l.Split('@')[1].Split(':')[1].Split('x')[1].Trim()),
	})
	.SelectMany(l => Enumerable.Range(0, l.W).SelectMany(wx => Enumerable.Range(0, l.H).Select(hy => new { Coord=(l.X+wx, l.Y+hy), Source=l })))
	.GroupBy(p => p.Coord)
	.Where(p => p.Count() > 1)
	.Count()