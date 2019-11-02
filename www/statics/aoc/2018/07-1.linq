<Query Kind="Program" />

class Node { public char N; public List<Node> Precond = new List<Node>(); public List<Node> Postcond = new List<Node>(); }

void Main()
{
	var data = File
		.ReadAllLines(Path.Combine(Path.GetDirectoryName(Util.CurrentQueryPath), @"07_input.txt"))
		.Where(p => !string.IsNullOrWhiteSpace(p))
		.Select(l => (l[5], l[36]))
		.ToList();

	var nodes = data.SelectMany(p => new[] {p.Item1, p.Item2}).Distinct().Select(p => new Node {N=p}).ToList();

	foreach (var (pre, post) in data)
	{
		var n1 = nodes.First(p => p.N == pre);
		var n2 = nodes.First(p => p.N == post);

		n1.Postcond.Add(n2);
		n2.Precond.Add(n1);
	}
	
	var r = new StringBuilder();
	for(var fin = new HashSet<Node>(); fin.Count<nodes.Count;)
	{
		var n = nodes.Where(p => !fin.Contains(p)).Where(p => p.Precond.All(q => fin.Contains(q))).OrderBy(p=>p.N).First();
		fin.Add(n);
		r.Append(n.N);
	}
	r.ToString().Dump();
	
}

// Define other methods and classes here
