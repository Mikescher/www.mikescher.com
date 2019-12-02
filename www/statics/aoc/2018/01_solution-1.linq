<Query Kind="Expression" />

File
	.ReadAllLines(Path.Combine(Path.GetDirectoryName(Util.CurrentQueryPath), @"01_input.txt"))
	.Select(int.Parse)
	.Sum()