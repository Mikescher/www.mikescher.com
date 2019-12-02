<Query Kind="Program" />

class Node { public List<Node> Children = new List<Node>(); public List<int> Metadata = new List<int>(); }

void Main()
{
	var data = File
		.ReadAllText(Path.Combine(Path.GetDirectoryName(Util.CurrentQueryPath), @"08_input.txt"))
		.Split(' ')
		.Select(int.Parse)
		.ToList();
	
	int i = 0;
	var root = Parse(data, ref i);
	
	MetaSum(root).Dump();
}

private Node Parse(List<int> data, ref int pos)
{
	var qn = data[pos++];
	var qm = data[pos++];
	var n = new Node();
	for (int i = 0; i < qn; i++) n.Children.Add(Parse(data, ref pos));
	for (int i = 0; i < qm; i++) n.Metadata.Add(data[pos++]);
	return n;
}

private int MetaSum(Node n) => n.Metadata.Sum() + n.Children.Select(MetaSum).Sum();