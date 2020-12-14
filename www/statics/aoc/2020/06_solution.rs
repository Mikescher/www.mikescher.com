use crate::common::AdventOfCodeDay;

use std::collections::HashSet;
use regex::Regex;

#[derive(Debug)]
struct DeclForm {
    answers: HashSet<char>,
}

#[derive(Debug)]
struct Group {
    forms: Vec<DeclForm>,
}

#[derive(Debug)]
pub struct Day06 {
    groups: Vec<Group>,
}

fn parse_form(line: &str) -> DeclForm {
    DeclForm {
        answers: line.chars().collect(),
    }
}

fn parse_group(lines: &str) -> Group {
    Group {
        forms: lines.lines().map(parse_form).collect(),
    }
}

impl DeclForm {
    fn contains(&self, c: char) -> bool {
        self.answers.contains(&c)
    } 
}

impl Group {
    pub fn all_questions_any_yes(&self) -> Vec<char> {
        self.forms.iter().map(|p| p.answers.iter().collect::<Vec<&char>>()).flatten().collect::<HashSet<&char>>().iter().map(|p| **p).collect()
    }

    pub fn all_questions_all_yes(&self) -> Vec<char> {
        self.forms[0].answers.iter().filter(|p| self.forms.iter().all(|f| f.contains(**p))).map(|p| *p).collect()
    }
}

impl Day06 {
    pub fn new() -> Self {
        let input_bytes = include_bytes!("../res/06_input.txt");
        let input_str = String::from_utf8_lossy(input_bytes);
        
        
        let rex_lines = Regex::new(r"(\r?\n){2}").unwrap();

        let data = rex_lines.split(&input_str.to_owned())
                        .map(parse_group)
                        .collect::<Vec<Group>>();

        Self {
            groups: data,    
        }
    }
}

impl AdventOfCodeDay for Day06 {

    fn task_1(&self) -> String {
        if is_verbose!() {
            for r in &self.groups {
                verboseln!("{} {:?}", r.all_questions_any_yes().len(), r.all_questions_any_yes())
            }
        }
        return self.groups.iter().map(|p| p.all_questions_any_yes().len()).sum::<usize>().to_string();
    }

    fn task_2(&self) -> String  {
        return self.groups.iter().map(|p| p.all_questions_all_yes().len()).sum::<usize>().to_string();
    }
}