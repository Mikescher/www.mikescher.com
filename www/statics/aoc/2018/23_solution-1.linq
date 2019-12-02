<Query Kind="Statements" />

var input = File.ReadAllLines(Path.Combine(Path.GetDirectoryName(Util.CurrentQueryPath), @"23_input.txt"))
	.Where(p => !string.IsNullOrWhiteSpace(p))
	.Select(p => new
	{
		X = int.Parse(p.Split(' ')[0].Substring(5).Split(',')[0].Trim(new[] { ' ', '<', '>', ',' })),
		Y = int.Parse(p.Split(' ')[0].Substring(5).Split(',')[1].Trim(new[] { ' ', '<', '>', ',' })),
		Z = int.Parse(p.Split(' ')[0].Substring(5).Split(',')[2].Trim(new[] { ' ', '<', '>', ',' })),
		R = int.Parse(p.Split(' ')[1].Substring(2).Trim(new[] { ' ', '<', '>', ',' })),
	})
	.ToList();
	
	var max = input.OrderByDescending(p => p.R).First();
	
	input.Count(i => Math.Abs(i.X-max.X) + Math.Abs(i.Y-max.Y) + Math.Abs(i.Z-max.Z) <= max.R).Dump();