use crate::common::AdventOfCodeDay;

#[derive(Debug,Clone)]
pub struct Day16 {
    rules: Vec<Rule>,
    ticket: RawTicketData,
    nearby: Vec<RawTicketData>,
}

#[derive(Debug,Clone)]
struct Rule {
    name: String,
    ranges: Vec<(i32, i32)>,
}

impl Rule {
    fn matches(&self, dat: i32) -> bool {
        return self.ranges.iter().any(|(lower, upper)| dat >= *lower && dat <= *upper);
    }
}

#[derive(Debug,Clone)]
struct RawTicketData {
    fields: Vec<i32>,
}

impl Day16 {
    pub fn new() -> Self {
        let input_bytes = include_bytes!("../res/16_input.txt");
        let input_str = String::from_utf8_lossy(input_bytes);
        
        let lines = input_str
                        .lines()
                        .map(|p| String::from(p))
                        .collect::<Vec<String>>();

        let mut i = 0;

        let mut rules: Vec<Rule> = Vec::new();
        loop {
            let line = lines[i].clone();
            if line == "" { i+=1; i+=1; break; }

            let s1 = line.split(": ").collect::<Vec<&str>>();
            let name = s1[0].to_owned();

            let s2 = s1[1].split(" or ").collect::<Vec<&str>>();

            let s21 = s2[0].split('-').collect::<Vec<&str>>();
            let range1 = (s21[0].parse::<i32>().unwrap(), s21[1].parse::<i32>().unwrap());

            let s22 = s2[1].split('-').collect::<Vec<&str>>();
            let range2 = (s22[0].parse::<i32>().unwrap(), s22[1].parse::<i32>().unwrap());

            rules.push(Rule {
                name: name,
                ranges: vec![ range1, range2 ],
            });
            
            i+=1;
        }

        let myticket = RawTicketData {
            fields: lines[i].split(',').map(|p| p.parse::<i32>().unwrap()).collect(),
        };
        i+=1;
        
        i+=1;
        i+=1;

        let mut nearbytickets: Vec<RawTicketData> = Vec::new();
        while i < lines.len() {

            nearbytickets.push(RawTicketData {
                fields: lines[i].split(',').map(|p| p.parse::<i32>().unwrap()).collect(),
            });
            
            i+=1;
        }

        Self {
            rules: rules,
            ticket: myticket,
            nearby: nearbytickets,
        }
    }
}

impl AdventOfCodeDay for Day16 {

    fn task_1(&self) -> String {
        return self.nearby
                   .iter()
                   .flat_map(|p| p.fields.iter())
                   .filter(|f| self.rules.iter().all(|r| !r.matches(**f)))
                   .sum::<i32>()
                   .to_string();
    }

    fn task_2(&self) -> String  {
        
        let valid = self.nearby
                        .iter()
                        .filter(|p| p.fields.iter().all(|f| self.rules.iter().any(|r| r.matches(*f))))
                        .map(|p| p.clone())
                        .collect::<Vec<RawTicketData>>();

        let mut candidates: Vec<(Rule, Vec<usize>)>;
        candidates = self.rules
                         .iter()
                         .map(|rule| (rule.clone(), (0..self.ticket.fields.len())
                           .filter(|i| rule.matches(self.ticket.fields[*i]))
                           .filter(|i| valid.iter().all(|d| rule.matches(d.fields[*i]) ) )
                           .map(|p| p.clone())
                           .collect::<Vec<usize>>()))
                         .collect::<Vec<(Rule, Vec<usize>)>>();

        verboseln!();
        if is_verbose!() { for c in &candidates { verboseln!("{}: {:?}", c.0.name, c.1); } }
        verboseln!();

        while candidates.iter().any(|c| c.1.len() != 1) {

            let rm = candidates.iter()
                               .filter(|c| c.1.len() == 1)
                               .flat_map(|p| p.1.iter())
                               .filter(|p| candidates.iter().filter(|c| c.1.contains(p)).count() > 1)
                               .map(|p|p.clone())
                               .collect::<Vec<usize>>();

            // Field {rm} is teh single candidate of a rule and so it can not be a candidate for any other rule
            verboseln!("Remove {:?}", rm);
            for c in candidates.iter_mut().filter(|c| c.1.len() > 1) { c.1.retain(|v| !rm.contains(v) ); }

            let unique = (0..self.ticket.fields.len())
                              .filter(|i| candidates.iter().filter(|c| c.1.contains(i)).count() == 1)
                              .filter(|i| candidates.iter().filter(|c| c.1.contains(i) && c.1.len() > 1).count() == 1)
                              .map(|p|p.clone())
                              .collect::<Vec<usize>>();
                            
            // Field {uniq} only appears in one rule and so it must be the candidate for that rule
            verboseln!("Clean {:?}", unique);
            for ui in &unique {
                for c in candidates.iter_mut().filter(|c| c.1.contains(ui)) { c.1.retain(|v| v == ui ); }
            }
        }

        verboseln!();
        if is_verbose!() { for c in &candidates { verboseln!("{}: {:?} => {}", c.0.name, c.1, self.ticket.fields[c.1[0]]); } }
        verboseln!();

        return candidates.iter()
                         .filter(|c| c.0.name.starts_with("departure"))
                         .map(|c| c.1[0])
                         .map(|i| self.ticket.fields[i])
                         .map(|v| v as u128)
                         .fold(1, |a,b| a*b)
                         .to_string();
    }
}