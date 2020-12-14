use crate::common::AdventOfCodeDay;

use std::collections::VecDeque;
use std::collections::HashSet;
use regex::Regex;

#[derive(Debug)]
struct Rule {
    parent: String,
    children: Vec<(usize, String)>,
}

pub struct Day07 {
    input: Vec<Rule>,
}

fn parse_line(line: &str) -> Rule {
    lazy_static! {
        static ref REX_LINE:  Regex = Regex::new(r"^(?P<bag>[a-z]+ [a-z]+) bags contain (?P<inner>(?:(?:(?:[0-9]+ (?:[a-z]+ [a-z]+)) bags?(?:, |\.)?)+)|no other bags\.)$").unwrap();
        static ref REX_INNER: Regex = Regex::new(r"(?P<num>[0-9]+) (?P<bag>[a-z]+ [a-z]+) bags?[.,]").unwrap();
    }

    if let Some(rline) = REX_LINE.captures(line) {
        let parent = rline.name("bag").unwrap().as_str().to_owned();

        if rline.name("inner").unwrap().as_str() == "not other bags." {
            return Rule {
                parent: parent,
                children: vec![],
            }
        }

        let childs = REX_INNER
                        .captures_iter(rline.name("inner").unwrap().as_str())
                        .map(|p| (p.name("num").unwrap().as_str().parse::<usize>().unwrap(), p.name("bag").unwrap().as_str().to_owned()))
                        .collect::<Vec<(usize, String)>>();

        return Rule {
            parent: parent,
            children: childs,
        }
    } else {
        panic!(format!("no regex line match: '{}'", line.to_owned()));
    }

}

impl Day07 {
    pub fn new() -> Self {
        let input_bytes = include_bytes!("../res/07_input.txt");
        let input_str = String::from_utf8_lossy(input_bytes);
        
        let data = input_str
                        .lines()
                        .map(parse_line)
                        .collect::<Vec<Rule>>();

        Self {
            input: data
        }
    }

    fn find_rule(&self, bag: &str) -> Option<&Rule> {
        for r in &self.input {
            if r.parent == bag {
                return Some(r);
            }
        }
        return None;
    }
    
    fn can_contain(&self, parent: &str, child: &str) -> bool {
        let mut candidates: VecDeque<String> = VecDeque::new();
        let mut visited: HashSet<String> = HashSet::new();
    
        candidates.push_back(parent.to_owned());
        visited.insert(parent.to_owned());
    
        while !candidates.is_empty() {
            let cand = candidates.pop_back().unwrap();
            if let Some(rule) = self.find_rule(cand.as_str()) {
                for rulechild in &rule.children {
                    let rcname = rulechild.1.to_owned();
                    if rcname == child {
                        return true;
                    } else if !visited.contains(&rcname) {
                        candidates.push_back(rcname.to_owned());
                        visited.insert(rcname);
                    }
                }
            }
        }
    
        return false;
    }

    fn get_full_children_count(&self, name: &str) -> usize {
        self.find_rule(name).unwrap().children.iter().map(|p| p.0 + p.0 * self.get_full_children_count(&p.1)).sum()
    }
}

impl AdventOfCodeDay for Day07 {

    fn task_1(&self) -> String {
        self.input.iter().filter(|p| self.can_contain(p.parent.as_str(), "shiny gold")).count().to_string()
    }

    fn task_2(&self) -> String  {
        self.get_full_children_count("shiny gold").to_string()
    }
}