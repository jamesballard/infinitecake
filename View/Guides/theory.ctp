<h1>Activity Theory</h1>
<p>An understanding of Activity Theory is not essential to use this site, however it is central to the
    research on which the design of the underlying data model is based. This overview is intended to
    give you an insight into how Infinite Rooms applies Activity Theory analysis to learner activity data.
    In practice this is handled auto-magically in the import modules.</p>

<p>Activity theory represents an approach to human activity based on historical and dialectical materialism
    originating in the works of Vygotsky (1978, 1987), Luria (1966) and Leont’ev (1978). Activity
    Theory determines human activity as the unit of analysis, which can be represented in two ways:
    ‘across time’ (synchronic) via Activity Systems and ‘over time’ (diachronic) through Activity Structure.
    The methodology requires constructing the activity through the lens of the subject or
    subjects (i.e. learners) such that the activity becomes a multi-voiced method for understanding underlying process
    dynamics as a method for identifying external correlations between variables.</p>

<h2>Activity Systems</h2>
<p>Engeström (1999)</p>
<table class="table table-striped pull-left" style="width: 500px" cellpadding="0" cellspacing="0">
    <tbody>
    <tr><th>Model</th><th>Description</th></tr>
    <tr>
        <td>Subject</td>
        <td>Users, agents who are undertaking the activity</td>
    </tr>
    <tr>
        <td>Artifact</td>
        <td>Instruments or tools such as forums, quizzes, blogs, assignments, etc.</td>
    </tr>
    <tr>
        <td>Object</td>
        <td>What is used or created by the activity, for example in a blog the ‘post’
            is the object, while a resource might use a document (e.g. handout
            or lecture video)</td>
    </tr>
    <tr>
        <td>Division of Labour</td>
        <td>The different roles in the system (e.g. teacher/student). In a VLE, for
            example, the teacher must create an activity before a student can
            participate.</td>
    </tr>
    <tr>
        <td>Community</td>
        <td>The social context in which the activity took place. For example a course
            is defined in a hierarchy (e.g. course > school > department > institution)
            Other groups might include special interest, study groups, or 1-to-1. </td>
    </tr>
    <tr>
        <td>Rules</td>
        <td>The conditions in which activity takes place - these can be cultural, such
            as norms and values, or operational, for example system features or processes.</td>
    </tr>
    <tr>
        <td>Outcome</td>
        <td>This typically requires contextual understanding as to whether the outcome
            accords with learner goals. This forms a bridge to assessment analytics.</td>
    </tr>
    </tbody>
</table>
<?php echo $this->Html->image('Activity-Theory-Complex.png', array('alt' => '', 'class' => 'pull-left', 'style' => 'margin-right: 20px')); ?>

<div class="clearfix"></div>
<h2>Activity Structures</h2>
    <p>Leont’ev (1978)</p>
    <table class="table table-striped pull-left" style="width: 500px" cellpadding="0" cellspacing="0">
        <tbody>
        <tr><th>Model</th><th>Description</th></tr>
        <tr>
            <td>Activity</td>
            <td>Activities are distinguished by their objects, where the object of activity is
                its motive. This may be both material and ideal; it may be given in
                perception or it may exist only in imagination, in the mind.</td>
        </tr>
        <tr>
            <td>Action</td>
            <td>A process obeying a conscious goal (e.g. post to forum, send message,
                submit work) that realise activity. One and the same action may realise
                various activities.</td>
        </tr>
        <tr>
            <td>Operation</td>
            <td>The conditions required for the attainment of a specific goal form into
                operations. However, the formulation of operations proceeds entirely
                differently from that of actions.</td>
        </tr>
        </tbody>
    </table>
<?php echo $this->Html->image('activity-structure.png', array('alt' => '', 'class' => 'pull-left', 'style' => 'margin-right: 20px')); ?>

<div class="clearfix"></div>
<h2>Infinite Rooms Activity Model</h2>
<p>Describing actions allows one to model activity over time without losing the inherent logic of the
    system in which it is occurring. The intention is to create action as an independent pedagogical
    form that provides a way of relating pedagogical processes with learning outcomes. This can be
    achieved through associating the 'action' of Activity Structure with the consumption and production
    segments of the Activity System (i.e. action uses or creates an object) and associating
    'operations' as 'rules' (i.e. conditions).</p>

<p>In a data warehouse approach the action can be treated a fact, that occurs within two-tiers of
    dimensions. The system dimensions describe this from the view of a specific system (e.g. Moodle).
    The customer dimensions contextualise the action and link dimensions across systems. For example
    a learner may be a user on multiple systems and a course might be represented in a VLE, e-portfolio
    and external assessment system. This model allows systems to be interchanged within a consistent
    data framework.
</p>


<div class="clearfix"></div>
<h2>Expansive Development</h2>
<p>Engeström (1987)</p>
<?php echo $this->Html->image('spiral-model-engestrom.png', array('alt' => '', 'class' => 'pull-left', 'style' => 'margin-right: 20px')); ?>
<p class="clearfix">Engeström argues for a methodology that can study expansive cycles through models
    of activity constructed jointly with participants, for which he proposes the cycle of expansive
    developmental research. This methodology has been adopted to design the architecture of the
    Infinite Rooms application.</p>
<dl class="dl-horizontal">
    <dt>Phenomenology Delineation</dt>
    <dd class="clearfix">The raw log data will first be analysed as activity to identify appropriate levels and information.
        This is handled in the import process for each system as above.</dd>
    <dt>Analysis of Activity</dt>
    <dd class="clearfix">The data is aggregated based on existing classifications to provide a system independent
        presentation of this data. (see
        <?php echo $this->Html->link('Analyse', array('controller' => 'Guides', 'action' => 'analyse')); ?>
        )</dd>
    <dt>New Instrument Formation</dt>
    <dd class="clearfix">New classification models and approaches can be developed by users to explore different
        understandings of the data. (see
        <?php echo $this->Html->link('Develop', array('controller' => 'Guides', 'action' => 'develop')); ?>
        )</dd>
    <dt>Application of New Instruments</dt>
    <dd class="clearfix">As new models evovle so will new understanding of learner engagement, that can then be shared
        within the community to explore their significance.</dd>
    <dt>Reporting and Evaluation</dt>
    <dd class="clearfix">The feedback and evaluation loop is important to ensure that improvements to the feature set of
        the overall application develop in line with research findings.</dd>
</dl>

<div class="clearfix"></div>
<h2>References</h2>
<div class="well well-small">Engeström, Y. (1987).
    <a href="http://communication.ucsd.edu/MCA/Paper/Engestrom/expanding/toc.htm">Learning by expanding:
        An activity-theoretical approach to developmental research.</a> Helsinki: Orienta-Konsultit.</div>

<div class="well well-small">Engeström, Y., Miettinen, R., & Punamäki, R.-L. (Eds.). (1999).
    Perspectives on Activity Theory (Learning in Doing: Social, Cognitive and Computational Perspectives).
    Cambridge: Cambridge University Press.</div>

<div class="well well-small">Leontʼev, A. N. (1978).
    <a href="http://www.marxists.org/archive/leontev/works/1978/index.htm">Activity, consciousness, and personality.</a>
    Englewood Cliffs: Prentice-Hall.</div>
<div class="well well-small">Luria, A. R. (1966). Higher Cortical Function Man. New York: Basic Books.</div>
<div class="well well-small">Vygotsky, L. (1978). Mind in Society. Cambridge, MA and London:
    Harvard University Press.</div>
<div class="well well-small">Vygotsky, L. (1986). Thought and Language. London and Cambridge, MA:
    The MIT Press.</div>
