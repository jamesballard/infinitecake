<h1>Analyse</h1>
<h2>Dashboards</h2>
<p>There are 3 dashboards through which reports can be viewed:</p>
<ul>
    <li>Overall Statistics: this summarizes all user data to give an indication of general trends of use;</li>
    <li>Course Profile: this summarises all data for users assigned to a course and allows comparisons between users;</li>
    <li>User Profile: this summaries all data for an individual person.</li>
</ul>
<p>A search option is provided to find courses and users - type at least 3 characters to narrow down the options.</p>

<h2>Reports</h2>
<p>The reports are identical for each dashboard but calculate summaries based on your chosen perspective:</p>
<?php echo $this->element('standardReportHelps'); ?>

<h2>Visualisation</h2>
<p>The visualisation shows the data report in your chosen format, either graphical or in a data table.
    Some reports generate specific visualisations, whereas others support various graph types. The
    following general approaches apply:</p>

    <ul>
        <li>Area, Bar, Column, and Line are typically stacked so that the x-axis is time, the y-axis is
            total actions and the colour-coding represents how they have been stacked or grouped;</li>
        <li>Pie and TreeMap charts represent the percentage of the total for each colour-coded item.</li>
        <li>Tables show the raw data values</li>
    </ul>

<h2>Report Options</h2>
<p>The report options allow you to configure the visualisation display:</p>
<ul>
    <li>Report - changes how the total value (y-axis) is calculated where applicable (e.g. activity or
        users)</li>
    <li>Chart Type - change the type of visualisation (line, bar, pie, data table etc.)</li>
    <li>Date Range - determines how far back the report will query the data</li>
    <li>System - allows you to filter by particular systems</li>
    <li>Period - this allows you to alter the period of the x-axis for time series data (day, week, month)</li>
    <li>Width/Height - changes the size of the graph to scale for granularity</li>
</ul>