class Fighter {
    constructor(id, name, age, catInfo, record, img) {
        this.id = id
        this.name = name
        this.age = age
        this.catInfo = catInfo
        this.record = record
        this.img = img
    }
}

class Record {
    constructor(wins, loss) {
        this.wins = wins
        this.loss = loss
    }
}

class GameMechanic {
    constructor() {
        this.fightInProgress = false
        this.leftFighter = null
        this.rightFighter = null
        this.leftFighters = []
        this.rightFighters = []
    }

    init() {
        this.isReady()
        const fightButton = document.querySelector("#generateFight")
        fightButton.addEventListener("click", this.fightButtonClicked.bind(this))

        const selectRandomFightersButton = document.querySelector("#randomFight")
        selectRandomFightersButton.addEventListener("click", this.selectRandomFighters.bind(this))

        let buttons = document.querySelector("#firstSide").querySelectorAll(".fighter-box")
        Array.from(buttons).forEach(el => {
            let img = el.querySelector("img").getAttribute("src")
            let json = JSON.parse([el.dataset["info"]])
            let fighter = new Fighter(json.id, json.name, json.age, json.catInfo, new Record(json.record.wins, json.record.loss), img)
            this.leftFighters.push(fighter)
        })
        buttons.forEach((button) => {
            button.addEventListener("click", this.selectLeftFighter.bind(this))
        })

        buttons = document.querySelector("#secondSide").querySelectorAll(".fighter-box")
        Array.from(buttons).forEach(el => {
            let img = el.querySelector("img").getAttribute("src")
            let json = JSON.parse([el.dataset["info"]])
            let fighter = new Fighter(json.id, json.name, json.age, json.catInfo, new Record(json.record.wins, json.record.loss), img)
            this.rightFighters.push(fighter)
        })
        buttons.forEach((button) => {
            button.addEventListener("click", this.selectRightFighter.bind(this))
        })
    }

    selectLeftFighter(event) {
        if (this.fightInProgress === false) {
            document.querySelector("#leftFighterImg").removeAttribute("style")
            document.querySelector("#rightFighterImg").removeAttribute("style")
            let data = event.path[1]
            let img = event.target.getAttribute("src")
            let dataObj = JSON.parse([data.dataset["info"]])
            
            if (this.rightFighter === null || this.rightFighter.id !== dataObj.id) {
                this.leftFighter = new Fighter(dataObj.id, dataObj.name, dataObj.age, dataObj.catInfo, new Record(dataObj.record.wins, dataObj.record.loss), img)

                this.setLeftFighter(this.leftFighter)
            }
        }
        this.isReady()
    }

    selectRightFighter(event) {
        if (this.fightInProgress === false) {
            document.querySelector("#leftFighterImg").removeAttribute("style")
            document.querySelector("#rightFighterImg").removeAttribute("style")
            let data = event.path[1]
            let img = event.target.getAttribute("src")
            let dataObj = JSON.parse([data.dataset["info"]])

            if (this.leftFighter === null || this.leftFighter.id !== dataObj.id) {
                this.rightFighter = new Fighter(dataObj.id, dataObj.name, dataObj.age, dataObj.catInfo, new Record(dataObj.record.wins, dataObj.record.loss), img)

                this.setRightFighter(this.rightFighter)
            }
        }
        this.isReady()
    }

    selectRandomFighters() {
        if (this.fightInProgress === false) {
            document.querySelector("#leftFighterImg").removeAttribute("style")
            document.querySelector("#rightFighterImg").removeAttribute("style")
            let LFRandomInt = Math.floor(Math.random() * fighterCount)
            let RFRandomInt = Math.floor(Math.random() * fighterCount)
            while(LFRandomInt === RFRandomInt) {
                RFRandomInt = Math.floor(Math.random() * fighterCount)
            }
            
            this.leftFighter = this.leftFighters[LFRandomInt]
            this.rightFighter = this.rightFighters[RFRandomInt]

            this.setLeftFighter(this.leftFighter)
            this.setRightFighter(this.rightFighter)
        }
        this.isReady()
    }

    fightButtonClicked() {
        if (this.isReady()) {
            document.querySelector("#leftFighterImg").removeAttribute("style")
            document.querySelector("#rightFighterImg").removeAttribute("style")
            this.fightInProgress = true
            this.isReady()
            document.querySelector("#infoScreen").innerHTML = 3
            window.timer = setInterval(this.countdown.bind(this), 1000)
        }
    }

    countdown() {
        if (document.querySelector("#infoScreen").innerHTML - 1 <= 0) {
            clearInterval(window.timer)
            this.fight()
        } else {
            document.querySelector("#infoScreen").innerHTML -= 1
        }
    }

    fight() {
        const LFWinRatio = this.leftFighter.record.wins/(this.leftFighter.record.wins + this.leftFighter.record.loss)
        const RFWinRatio = this.rightFighter.record.wins/(this.rightFighter.record.wins + this.rightFighter.record.loss)

        let LFInterval, RFInterval
        let diff = (LFWinRatio - RFWinRatio) * 100
        if (diff >= 0) {
            if (Math.abs(diff) > 10) {
                LFInterval = [0, 69]
                RFInterval = [70,99]
            } else {
                LFInterval = [0,59]
                RFInterval = [60,99]
            }
        } else {
            if (Math.abs(diff) > 10) {
                RFInterval = [0, 69]
                LFInterval = [70,99]
            } else {
                RFInterval = [0,59]
                LFInterval = [60,99]
            }
        }

       
        let winner = Math.floor(Math.random() * 100)
        if (winner >= LFInterval[0] && winner <= LFInterval[1]) {
            this.updateData(this.leftFighter, this.rightFighter, true)
            document.querySelector("#leftFighterImg").setAttribute("style", "border: 10px solid green;")
            document.querySelector("#rightFighterImg").setAttribute("style", "border: 10px solid red;")
            document.querySelector("#infoScreen").innerHTML = this.leftFighter.name + " wins!"
        } else {
            this.updateData(this.rightFighter, this.leftFighter, false)
            document.querySelector("#leftFighterImg").setAttribute("style", "border: 10px solid red;")
            document.querySelector("#rightFighterImg").setAttribute("style", "border: 10px solid green;")
            document.querySelector("#infoScreen").innerHTML = this.rightFighter.name + " wins!"
        }

        this.fightInProgress = false
        this.isReady()
    }

    updateData(winner, loser, leftWon) {
        // ova funkcija se poziva kada se borba završi i šalje id u UpdateStats.php ovisno o tome tko je pobjedio a tko izgubio
        $.ajax({
            type: "POST",
            url: "./controller/db/UpdateStats.php",
            data: {
                winId:winner.id,
                lossId:loser.id
            },
            success: function(response) {
                console.log(response)
            }
        })

        winner.record.wins++
        loser.record.loss++
        
        if (leftWon) {
            this.setLeftFighter(winner)
            this.setRightFighter(loser)
        } else {
            this.setLeftFighter(loser)
            this.setRightFighter(winner)
        }

        this.leftFighters.forEach(fighter => {
            if (fighter.id === winner.id) {
                fighter.record.wins += 1
            }
            if (fighter.id === loser.id) {
                fighter.record.loss += 1
            }
        })

        this.rightFighters.forEach(fighter => {
            if (fighter.id === winner.id) {
                fighter.record.wins += 1
            }
            if (fighter.id === loser.id) {
                fighter.record.loss += 1
            }
        })

        this.leftFighters.forEach(fighter => {
            if (fighter.id === winner.id) {
                let element = document.querySelector("#firstSide").querySelector("#id-" + fighter.id)
                let data = JSON.parse(element.getAttribute("data-info"))
                data.record.wins = fighter.record.wins
                element.setAttribute("data-info", JSON.stringify(data))
            } else if (fighter.id === loser.id) {
                let element = document.querySelector("#firstSide").querySelector("#id-" + fighter.id)
                let data = JSON.parse(element.getAttribute("data-info"))
                data.record.loss = fighter.record.loss
                element.setAttribute("data-info", JSON.stringify(data))
            }
        })

        this.rightFighters.forEach(fighter => {
            if (fighter.id === winner.id) {
                let element = document.querySelector("#secondSide").querySelector("#id-" + fighter.id)
                let data = JSON.parse(element.getAttribute("data-info"))
                data.record.wins = fighter.record.wins
                element.setAttribute("data-info", JSON.stringify(data))
            } else if (fighter.id === loser.id) {
                let element = document.querySelector("#secondSide").querySelector("#id-" + fighter.id)
                let data = JSON.parse(element.getAttribute("data-info"))
                data.record.loss = fighter.record.loss
                element.setAttribute("data-info", JSON.stringify(data))
            }
        })
    }

    isReady() {
        if (this.leftFighter !== null && this.rightFighter !== null && this.fightInProgress === false) {
            this.enableFightButton(true)
            this.enableRandomFightersButton(true)
            this.enableEditFighterButton(true)
            this.enableNewFighterButton(true)
            return true
        } else {
            this.enableFightButton(false)
            if (this.fightInProgress) {
                this.enableRandomFightersButton(false)
                this.enableEditFighterButton(false)
                this.enableNewFighterButton(false)
            }
            return false
        }
    }

    setLeftFighter(fighter) {
        document.querySelector("#leftFighterImg").src = fighter.img
        document.querySelector("#firstSide").querySelector(".name").innerHTML = fighter.name
        document.querySelector("#firstSide").querySelector(".age").innerHTML = fighter.age
        document.querySelector("#firstSide").querySelector(".skills").innerHTML = fighter.catInfo
        document.querySelector("#firstSide").querySelector(".wins").innerHTML = fighter.record.wins
        document.querySelector("#firstSide").querySelector(".loss").innerHTML = fighter.record.loss
    }

    setRightFighter(fighter) {
        document.querySelector("#rightFighterImg").src = fighter.img
        document.querySelector("#secondSide").querySelector(".name").innerHTML = fighter.name
        document.querySelector("#secondSide").querySelector(".age").innerHTML = fighter.age
        document.querySelector("#secondSide").querySelector(".skills").innerHTML = fighter.catInfo
        document.querySelector("#secondSide").querySelector(".wins").innerHTML = fighter.record.wins
        document.querySelector("#secondSide").querySelector(".loss").innerHTML = fighter.record.loss
    }

    enableFightButton(value) {
        let element = document.querySelector("#generateFight")
        if (value === true) {
            element.setAttribute("enabled", true)
            element.removeAttribute("disabled")
        } else {
            element.setAttribute("disabled", true)
            element.removeAttribute("enabled")
        }
    }

    enableRandomFightersButton(value) {
        let element = document.querySelector("#randomFight")
        if (value === true) {
            element.setAttribute("enabled", true)
            element.removeAttribute("disabled")
        } else {
            element.setAttribute("disabled", true)
            element.removeAttribute("enabled")
        }
    }

    enableEditFighterButton(value) {
        let element = document.querySelectorAll("#editFighter")
        Array.from(element).forEach(el => {
            if (value === true) {
                el.setAttribute("enabled", true)
                el.removeAttribute("disabled")
            } else {
                el.setAttribute("disabled", true)
                el.removeAttribute("enabled")
            }
        })
    }

    enableNewFighterButton(value) {
        let element = document.querySelector("#newFighter")
        if (value === true) {
            element.setAttribute("href", "addFighter.html")
        } else {
            element.setAttribute("href", "#")
        }
    }

    countdown2() {
        document.querySelector("#infoScreen").innerHTML = 2
    }

    countdown1() {
        document.querySelector("#infoScreen").innerHTML = 1
    }
}

const game = new GameMechanic
game.init()