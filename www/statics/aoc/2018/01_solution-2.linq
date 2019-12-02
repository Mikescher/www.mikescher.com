<Query Kind="Statements" />

HashSet<int> visited = new HashSet<int>();
int sum = 0;
foreach (var v in Enumerable.Repeat(File.ReadAllLines(Path.Combine(Path.GetDirectoryName(Util.CurrentQueryPath), @"01_input.txt")).Select(int.Parse), int.MaxValue).SelectMany(p=>p))
{
	sum += v;
	if (!visited.Add(sum)) { sum.Dump(); return; }
}