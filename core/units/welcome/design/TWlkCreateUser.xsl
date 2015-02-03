<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" encoding="utf-8" indent="no"/>
    <xsl:template match="TWlkCreateUser">
        <div class="welcome-box">
            <div class="inner">
                <div class="tnx">Thank you for using AllUnit.</div>
                <div class="content">
                    Next step: create admin user with <i>createAuUser</i> 
                    <a href="#link-to-docs" class="help-link" title="how?">?</a>
                </div>
                <a class="button" href="{//siteurl}">Done</a>
            </div>
        </div>
    </xsl:template>
</xsl:stylesheet>
