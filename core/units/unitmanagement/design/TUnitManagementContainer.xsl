<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" encoding="utf-8" indent="no"/>
    <xsl:template match="TUnitManagementContainer">
        <div class="main-wrapper unitmanagement">
        <h1>Manage units</h1>
        <div>
            <xsl:apply-templates />
        </div>
        </div>
    </xsl:template>
</xsl:stylesheet>
