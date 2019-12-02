<Query Kind="Expression" />

File
	.ReadAllLines(Path.Combine(Path.GetDirectoryName(Util.CurrentQueryPath), @"02_input.txt"))
	.Select(s => (s.GroupBy(p => p).Any(g => g.Count() == 2) ? 1 : 0, s.GroupBy(p => p).Any(g => g.Count() == 3) ? 1 : 0))
	.Select(p => new[] { p.Item1, p.Item2 })
	.Aggregate((a, b) => new[] { a[0] + b[0], a[1] + b[1] })
	.Aggregate((a, b) => a * b)