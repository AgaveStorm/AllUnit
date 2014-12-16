<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" encoding="utf-8" indent="no"/>
    <xsl:template match="TBkContentEditControl">
        <xsl:variable name="fields" select="fields"/>
        <xsl:variable name="values" select="values"/>
        <div class="bk-edit-content">
            <form method="post">
                <xsl:if test="id">
                    <input type="hidden" name="id" value="{id}"/>
                </xsl:if>
                <xsl:for-each select="fields/item">
                    <xsl:variable name="name" select="name"/>
                    <xsl:call-template name="EditField">
                        <xsl:with-param name="field" select="."/>
                        <xsl:with-param name="value" select="$values/*[name() = $name]"/>
                    </xsl:call-template>
                </xsl:for-each>
                <div class="clear"/>
                <input type="submit" name="onSaveClick" value="Save"/>
            </form>
        </div>
    </xsl:template>
    <xsl:include href="EditField.xsl"/>
</xsl:stylesheet>
