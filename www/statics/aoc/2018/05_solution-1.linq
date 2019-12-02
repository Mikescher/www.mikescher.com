<Query Kind="Statements" />

var poly = File.ReadAllText(Path.Combine(Path.GetDirectoryName(Util.CurrentQueryPath), @"05_input.txt")).Trim();
for (;;)
{
	var len = poly.Length;
	for (var i='a';i<='z';i++) poly=poly.Replace(i+""+char.ToUpper(i), "");
	for (var i='a';i<='z';i++) poly=poly.Replace(char.ToUpper(i)+""+i, "");
	if (len == poly.Length) { poly.Length.Dump(); return; }
}