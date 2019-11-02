<Query Kind="Program" />

class Node { public char N; public List<Node> Precond = new List<Node>(); public List<Node> Postcond = new List<Node>(); }
class Worker { public Node curr; public int Remaining; }
void Main()
{
	var data = File
		.ReadAllLines(Path.Combine(Path.GetDirectoryName(Util.CurrentQueryPath), @"07_input.txt"))
		.Where(p => !string.IsNullOrWhiteSpace(p))
		.Select(l => (l[5], l[36]))
		.ToList();

	var nodes = data.SelectMany(p => new[] { p.Item1, p.Item2 }).Distinct().Select(p => new Node { N = p }).ToList();

	foreach (var (pre, post) in data)
	{
		var n1 = nodes.First(p => p.N == pre);
		var n2 = nodes.First(p => p.N == post);

		n1.Postcond.Add(n2);
		n2.Precond.Add(n1);
	}

	var workers = Enumerable.Repeat(0, 5).Select(p => new Worker()).ToList();

	var started = new HashSet<Node>();
	var fin = new HashSet<Node>();
	var done = new StringBuilder();
	for (int sec = 0; workers.Any(n => n.curr != null) || fin.Count < nodes.Count; sec++)
	{
		foreach (var w in workers.Where(p => p.curr != null))
		{
			if (--w.Remaining == 0)
			{
				started.Remove(w.curr);
				done.Append(w.curr.N);
				fin.Add(w.curr);
				w.curr = null;
			}
		}

		foreach (var w in workers.Where(p => p.curr == null))
		{
			var n = nodes
				.Where(p => !started.Contains(p))
				.Where(p => !fin.Contains(p))
				.Where(p => p.Precond.All(q => fin.Contains(q)))
				.OrderBy(p => p.N)
				.FirstOrDefault();
			if (n == null) continue;
			w.curr = n;
			w.Remaining = 60 + 1 + (n.N - 'A');
			started.Add(n);
		}

		$"{sec:000}    {string.Join(" ", workers.Select(w => (w?.curr?.N ?? '.').ToString()))}   {done.ToString()}".Dump();
	}

}

// Define other methods and classes here
