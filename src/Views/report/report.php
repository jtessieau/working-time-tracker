<div class="container my-6">
    <h1 class="title has-text-centered">Report</h1>

    <nav class="pagination is-centered yearDisplay" role="navigation" aria-label="pagination">
        <ul class="pagination-list">
            <?php
            foreach ($report as $key => $data) {
                echo "<li><a id=\"year{$key}\"class=\"pagination-link\" aria-label=\"Goto year $key\">$key</a></li>";
            }
            ?>
        </ul>
    </nav>
    <nav class="pagination is-centered" role="navigation" aria-label="pagination">
        <ul class="pagination-list weekDisplay">
        </ul>
    </nav>
    <table class="table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Hours</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<?php
var_dump($report);
?>

<script>
    const data = <?= json_encode($report); ?>;
    console.log(data)
    const yearDisplay = document.querySelector(".yearDisplay");
    const weekDisplay = document.querySelector(".weekDisplay");

    let year
    let week

    yearDisplay.addEventListener("click", (e) => {
        weekDisplay.innerHTML = ''
        let current = document.querySelector('.yearDisplay .is-current');
        if (current) {
            current.classList.remove('is-current')
        }
        e.target.classList.toggle('is-current')


        year = e.target.innerText
        for (const key in data[year]) {
            console.log(key)
            let li = document.createElement('li')
            let link = document.createElement('a')
            link.classList.add('pagination-link')
            link.innerText = key

            li.appendChild(link)
            weekDisplay.appendChild(li)
        }
    })
    weekDisplay.addEventListener("click", (e) => {
        let current = document.querySelector('.weekDisplay .is-current');
        if (current) {
            current.classList.remove('is-current')
        }
        week = e.target.innerText
        document.querySelector('tbody').innerHTML = ''
        e.target.classList.toggle('is-current')
        if (JSON.stringify(data[year][week]) === '{}') {
            document.querySelector('table').innerHTML = "No entry this week."
        } else {
            for (const checkin of data[year][week]) {
                let row = document.createElement('tr')
                let date = document.createElement('td')
                date.innerText = checkin.Date
                let hours = document.createElement('td')
                hours.innerHTML = checkin.Hours
                let total = document.createElement('td')
                total.innerText = checkin.Total

                row.appendChild(date)
                row.appendChild(hours)
                row.appendChild(total)

                document.querySelector('tbody').appendChild(row)
            }
        }
    })
</script>