use std::collections::HashMap;

use crate::common::AdventOfCodeDay;
use regex::Regex;

pub struct Day19 {
    rules: HashMap<u32, Rule>,
    input: Vec<String>,
}

#[derive(Debug, Clone)]
enum Rule {
    RuleExpand(Vec<u32>),
    RuleSplit(Vec<u32>, Vec<u32>),
    RuleLiteral(char),
}

impl Day19 {
    pub fn new() -> Self {
        let input_bytes = include_bytes!("../res/19_input.txt");
        let input_str = String::from_utf8_lossy(input_bytes);

        let rex_lines = Regex::new(r"(\r?\n){2}").unwrap();
        let split = rex_lines.split(&input_str).collect::<Vec<&str>>();

        Self {
            rules: split[0].lines().map(|p| Day19::parse_rule(String::from(p))).collect(),
            input: split[1].lines().map(|p| String::from(p)).collect(),
        }
    }
}

impl Day19 {
    fn parse_rule(input: String) -> (u32, Rule) {
        lazy_static! {
            static ref REX_EXPAND: Regex = Regex::new(r#"^(?P<id>[0-9]+):(?P<exp>( [0-9]+)+)$"#).unwrap();
            static ref REX_SPLIT: Regex  = Regex::new(r#"^(?P<id>[0-9]+):(?P<exp1>( [0-9]+)+) \|(?P<exp2>( [0-9]+)+)$"#).unwrap();
            static ref REX_LITERAL: Regex  = Regex::new(r#"^(?P<id>[0-9]+): "(?P<chr>[a-z])"$"#).unwrap();
        }

        if let Some(cap) = REX_EXPAND.captures(&input) {
            let id = cap.name("id").unwrap().as_str().parse::<u32>().unwrap();
            let exp = cap.name("exp").unwrap().as_str().trim().split(' ').map(|p| p.parse::<u32>().unwrap()).collect::<Vec<u32>>();

            return (id, Rule::RuleExpand(exp));
        }

        if let Some(cap) = REX_SPLIT.captures(&input) {
            let id = cap.name("id").unwrap().as_str().parse::<u32>().unwrap();
            let exp1 = cap.name("exp1").unwrap().as_str().trim().split(' ').map(|p| p.parse::<u32>().unwrap()).collect::<Vec<u32>>();
            let exp2 = cap.name("exp2").unwrap().as_str().trim().split(' ').map(|p| p.parse::<u32>().unwrap()).collect::<Vec<u32>>();

            return (id, Rule::RuleSplit(exp1, exp2));
        }

        if let Some(cap) = REX_LITERAL.captures(&input) {
            let id = cap.name("id").unwrap().as_str().parse::<u32>().unwrap();
            let chr = cap.name("chr").unwrap().as_str().chars().nth(0).unwrap();

            return (id, Rule::RuleLiteral(chr));
        }

        panic!();
    }

    fn check_rule(rules: &HashMap<u32, Rule>, str: Vec<char>, exp: Vec<u32>) -> bool {

        if str.len() == 0 && exp.len() == 0 { return true; }
        
        if str.len() == 0 || exp.len() == 0 { return false; }

        let r = rules.get(&exp[0]).unwrap();

        match r {
            Rule::RuleLiteral(rchr) => {
                if *rchr != str[0] { return false; }
                let str_sub = str.iter().skip(1).map(|p| *p).collect::<Vec<char>>();
                let exp_sub = exp.iter().skip(1).map(|p| *p).collect::<Vec<u32>>();
                return Self::check_rule(rules, str_sub, exp_sub);
            }

            Rule::RuleExpand(rexp) => {
                let str_sub = str.clone();
                let mut exp_sub = rexp.clone();
                exp_sub.extend(exp.iter().skip(1).map(|p| *p));
                return Self::check_rule(rules, str_sub, exp_sub);
            }

            Rule::RuleSplit(rexp1, rexp2) => {
                let str_sub1 = str.clone();
                let mut exp_sub1 = rexp1.clone();
                exp_sub1.extend(exp.iter().skip(1).map(|p| *p));
                if Self::check_rule(rules, str_sub1, exp_sub1) { return true; }
                
                let str_sub2 = str.clone();
                let mut exp_sub2 = rexp2.clone();
                exp_sub2.extend(exp.iter().skip(1).map(|p| *p));
                if Self::check_rule(rules, str_sub2, exp_sub2) { return true; }

                return false;
            }
        }
    }
}

impl AdventOfCodeDay for Day19 {

    fn task_1(&self) -> String {

        return self.input.iter().filter(|v| Day19::check_rule(&self.rules, v.chars().collect(), vec![0]) ).count().to_string();

    }

    fn task_2(&self) -> String  {

        let mut rules = self.rules.clone();

        rules.insert(8, Rule::RuleSplit(vec![42], vec![42, 8]));
        rules.insert(11, Rule::RuleSplit(vec![42, 31], vec![42, 11, 31]));

        return self.input.iter().filter(|v| Day19::check_rule(&rules, v.chars().collect(), vec![0]) ).count().to_string();

    }
}