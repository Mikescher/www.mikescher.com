<Query Kind="Statements" />


var poly0 = File.ReadAllText(Path.Combine(Path.GetDirectoryName(Util.CurrentQueryPath), @"05_input.txt")).Trim();

var r = new List<(char, int)>();

for (var cc = 'a'; cc <= 'z'; cc++)
{
	var poly = poly0;
	poly = poly.Replace(cc + "", "");
	poly = poly.Replace(char.ToUpper(cc) + "", "");
	for (; ; )
	{
		var len = poly.Length;
		for (var i = 'a'; i <= 'z'; i++) poly = poly.Replace(i + "" + char.ToUpper(i), "");
		for (var i = 'a'; i <= 'z'; i++) poly = poly.Replace(char.ToUpper(i) + "" + i, "");
		if (len == poly.Length) { r.Add((cc, poly.Length)); break; }
	}
}

r.OrderBy(p => p.Item2).First().Item2.Dump();